<?php

namespace Yrial\Simrandom\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Application\Form\Type\ResultList;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedChallengeServiceInterface;
use Yrial\Simrandom\Domain\Dto\Input\ResultListDTO;

class SavedChallengeController extends AbstractController
{
    public function __construct(
        private readonly SavedChallengeServiceInterface $savedChallengeService,
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
            $challenge = $this->savedChallengeService->save($data->getName(), $data->getResultList()->toArray());
            return $this->json($challenge, Response::HTTP_CREATED);
        } else {
            return new JsonResponse(['message' => $form->getErrors()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/challenge/{id}/results', name: 'get_saved_challenge', methods: ['GET'])]
    public function findSavedChallenge(string $id): Response
    {
        $challenge = $this->savedChallengeService->find($id);
        if (empty($challenge)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        return $this->json($challenge);
    }
}