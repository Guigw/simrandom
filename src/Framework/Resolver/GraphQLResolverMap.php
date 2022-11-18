<?php

namespace Yrial\Simrandom\Framework\Resolver;

use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;
use Symfony\Component\Form\FormFactoryInterface;
use Yrial\Simrandom\Application\Command\ChallengeDraw\ChallengeDrawCommand;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Application\Dto\Challenge\ChallengeDto;
use Yrial\Simrandom\Application\Dto\Error\ChallengeDrawFormErrorDto;
use Yrial\Simrandom\Application\Dto\Error\ChallengeNotFoundDto;
use Yrial\Simrandom\Application\Dto\Error\RandomizerMissingArgsDto;
use Yrial\Simrandom\Application\Dto\Error\UnknownRandomizerDto;
use Yrial\Simrandom\Application\Dto\SavedChallengeDto;
use Yrial\Simrandom\Application\Query\DrawQuery;
use Yrial\Simrandom\Application\Query\FindChallengeDrawQuery;
use Yrial\Simrandom\Application\Query\FindChallengeQuery;
use Yrial\Simrandom\Application\Query\GetChallengeQuery;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Framework\Form\Input\ResultListDTO;
use Yrial\Simrandom\Framework\Form\Type\ResultList;

class GraphQLResolverMap extends ResolverMap
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly FormFactoryInterface $formFactory
    )
    {

    }

    protected function map(): array
    {
        return [
            'RootQuery' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'challenge' => $this->handleChallenge((int)$args['id']),
                        'challenges' => $this->commandBus->execute(new GetChallengeQuery()),
                        'getRandomizerResult' => $this->handleResults($args['title'], $args['number']),
                        'findSavedChallenge' => $this->commandBus->execute(
                            new FindChallengeDrawQuery($args['id'])
                        ),
                        default => null
                    };
                },
            ],
            'RootMutation' => [
                self::RESOLVE_FIELD => function (
                    $value,
                    ArgumentInterface $args,
                    ArrayObject $context,
                    ResolveInfo $info
                ) {
                    return match ($info->fieldName) {
                        'save' => $this->handleDrawForm($args->getArrayCopy()),
                        default => null
                    };
                },
            ],
            'ChallengeResult' => [
                self::RESOLVE_TYPE => function ($value) {
                    return is_a($value, ChallengeDto::class) ? 'ChallengeResponse' : 'ChallengeNotFound';
                }
            ],
            'Results' => [
                self::RESOLVE_TYPE => function ($value) {
                    return empty($value->results) ? 'RandomizerMissingArgs' : 'ResultResponse';
                }
            ],
            'SaveChallengeDrawResponse' => [
                self::RESOLVE_TYPE => function ($value) {
                    return is_a($value, SavedChallengeDto::class) ? 'SavedChallenge' : 'ChallengeDrawFormError';
                }
            ]
        ];
    }

    private function handleChallenge(int $id)
    {
        try {
            return $this->commandBus->execute(new FindChallengeQuery($id));
        } catch (ChallengeNotFoundException) {
            return new ChallengeNotFoundDto("Not Found");
        }
    }

    private function handleResults(string $title, ?int $number)
    {
        try {
            $result = $this->commandBus->execute(new DrawQuery($title, $number));
            if (empty($result->results)) {
                return new RandomizerMissingArgsDto($result->required);
            }
            return $result;
        } catch (RandomizerConfigurationNotFoundException|RandomizerNotFoundException) {
            return new UnknownRandomizerDto($title);
        }
    }

    private function handleDrawForm(array $args)
    {
        $data = [
          'name' => $args['name']['name'],
            'resultList' => array_map(function ($result) {
                return $result['id'];
            }, $args['results'])
        ];
        $form = $this->formFactory->create(ResultList::class);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ResultListDTO $data */
            $data = $form->getData();
            return $this->commandBus->execute(new ChallengeDrawCommand(
                $data->getName(),
                $data->getResultList()->toArray())
            );
        } else {
            return new ChallengeDrawFormErrorDto($form->getErrors(true, true));
        }
    }
}

