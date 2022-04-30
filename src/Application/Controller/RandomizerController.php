<?php

namespace Yrial\Simrandom\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Domain\Contract\UseCase\ResultServiceInterface;

class RandomizerController extends AbstractController
{
    public function __construct(
        private readonly ResultServiceInterface $resultService
    )
    {
    }

    #[Route('/randomizer/letter', name: 'randomizer_letter', methods: ['GET'])]
    public function letter(): Response
    {
        return $this->json($this->resultService->generate('letter'));
    }

    #[Route('/randomizer/rooms', name: 'randomizer_rooms', methods: ['GET'])]
    public function rooms(): Response
    {
        return $this->json($this->resultService->generate('rooms'));
    }

    #[Route('/randomizer/budget', name: 'randomizer_budget', methods: ['GET'])]
    public function budget(): Response
    {
        return $this->json($this->resultService->generate('budget'));
    }

    #[Route('/randomizer/buildings', name: 'randomizer_buildings', methods: ['GET'])]
    public function buildings(): Response
    {
        return $this->json($this->resultService->generate('buildings'));
    }

    #[Route('/randomizer/colors', name: 'randomizer_colors', defaults: ['number' => 0], methods: ['GET'])]
    public function colors(Request $request, int $number): Response
    {
        return $this->json($this->resultService->generate('colors', $request->query->get('number') ?? $number));
    }
}
