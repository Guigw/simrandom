<?php

namespace Yrial\Simrandom\Framework\Resolver;

use ArrayObject;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\ArgumentInterface;
use Overblog\GraphQLBundle\Resolver\ResolverMap;
use Yrial\Simrandom\Application\Command\ChallengeDraw\ChallengeDrawCommand;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Application\Dto\Challenge\ChallengeDto;
use Yrial\Simrandom\Application\Dto\Error\ChallengeNotFoundDto;
use Yrial\Simrandom\Application\Dto\Error\RandomizerMissingArgsDto;
use Yrial\Simrandom\Application\Dto\Error\UnknownRandomizerDto;
use Yrial\Simrandom\Application\Query\DrawQuery;
use Yrial\Simrandom\Application\Query\FindChallengeDrawQuery;
use Yrial\Simrandom\Application\Query\FindChallengeQuery;
use Yrial\Simrandom\Application\Query\GetChallengeQuery;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class GraphQLResolverMap extends ResolverMap
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
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
                        'save' => $this->commandBus->execute(
                            new ChallengeDrawCommand($args['name'], $args['results'])
                        ),
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
}

