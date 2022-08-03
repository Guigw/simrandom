<?php

namespace Yrial\Simrandom\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Domain\Command\Challenge\FindChallenge\JsonDetailChallengeCommand;
use Yrial\Simrandom\Domain\Command\Challenge\GetChallenge\JsonListChallengeCommand;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;

class ChallengeController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }

    #[Route('/challenge', name: 'challenge', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json($this->commandBus->execute(new JsonListChallengeCommand()));
    }


    #[Route('/challenge/{id}', name: 'challenge_randomizers', requirements: ['page' => '\d+'], methods: ['GET'])]
    public function getRandomizerList(int $id): Response
    {
        try {
            return $this->json($this->commandBus->execute(new JsonDetailChallengeCommand($id)));
        } catch (ChallengeNotFoundException $e) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }


}
