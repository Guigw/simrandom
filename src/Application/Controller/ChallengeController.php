<?php

namespace Yrial\Simrandom\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Domain\Contract\UseCase\ChallengeServiceInterface;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;

class ChallengeController extends AbstractController
{
    public function __construct(
        private readonly ChallengeServiceInterface $challengeService,
    )
    {
    }

    #[Route('/challenge', name: 'challenge', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json($this->challengeService->get());
    }


    #[Route('/challenge/{id}', name: 'challenge_randomizers', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function getRandomizerList(int $id): Response
    {
        try {
            return $this->json($this->challengeService->find($id));
        } catch (ChallengeNotFoundException $e) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }


}
