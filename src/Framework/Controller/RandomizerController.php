<?php

namespace Yrial\Simrandom\Framework\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Application\Contract\Bus\CommandBusInterface;
use Yrial\Simrandom\Domain\Command\Result\JsonResultCommand;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;

class RandomizerController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    )
    {
    }

    #[Route('/randomizer/{type}', name: 'randomizer_type', defaults: ['number' => 1], methods: ['GET'])]
    public function index(Request $request, string $type): Response
    {
        try {
            $command = new JsonResultCommand($type, $request->query->get('number') ?? null);
            return $this->json($this->commandBus->execute($command));
        } catch (RandomizerConfigurationNotFoundException|RandomizerNotFoundException $e) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
