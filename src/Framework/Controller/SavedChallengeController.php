<?php

namespace Yrial\Simrandom\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Domain\Command\SavedChallenge\JsonFindSavedChallenge;
use Yrial\Simrandom\Domain\Command\SavedChallenge\JsonRememberedChallengeCommand;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedChallengeServiceInterface;
use Yrial\Simrandom\Framework\Form\Input\ResultListDTO;
use Yrial\Simrandom\Framework\Form\Type\ResultList;

class SavedChallengeController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }

    #[Route('/challenge/save', name: 'challenge_save', methods: ['POST'])]
    public function saveChallenge(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ResultList::class);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ResultListDTO $data */
            $data = $form->getData();
            $challenge = $this->commandBus->execute(new JsonRememberedChallengeCommand($data->getName(), $data->getResultList()->toArray()));
            return $this->json($challenge, Response::HTTP_CREATED);
        } else {
            return new JsonResponse(['message' => $form->getErrors()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/challenge/{id}/results', name: 'get_saved_challenge', methods: ['GET'])]
    public function findSavedChallenge(string $id): Response
    {
        $challenge = $this->commandBus->execute(new JsonFindSavedChallenge($id));
        if (empty($challenge)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        return $this->json($challenge);
    }
}