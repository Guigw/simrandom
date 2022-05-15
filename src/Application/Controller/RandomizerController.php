<?php

namespace Yrial\Simrandom\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class RandomizerController extends AbstractController
{
    public function __construct(
        private readonly SavedResultServiceInterface $resultService
    )
    {
    }

    #[Route('/randomizer/{type}', name: 'randomizer_type', defaults: ['number' => 1], methods: ['GET'])]
    public function index(Request $request, string $type): Response
    {
        try {
            return $this->json($this->resultService->generate($type, $request->query->get('number') ?? null));
        } catch (RandomizerConfigurationNotFoundException|RandomizerNotFoundException $e) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
