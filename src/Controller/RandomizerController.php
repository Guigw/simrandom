<?php

namespace Yrial\Simrandom\Controller;

use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Generator\BudgetGenerator;
use Yrial\Simrandom\Generator\BuildingsGenerator;
use Yrial\Simrandom\Generator\ColorsGenerator;
use Yrial\Simrandom\Generator\Randomizer;
use Yrial\Simrandom\Generator\RoomsGenerator;
use Yrial\Simrandom\Generator\ShapeLetterGenerator;
use Yrial\Simrandom\Repository\RandomizerResultRepository;

class RandomizerController extends AbstractController
{
    private RandomizerResultRepository $repository;

    public function __construct(RandomizerResultRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/randomizer/letter', name: 'randomizer_letter', methods: ['GET'])]
    public function letter(ShapeLetterGenerator $shapeLetterGenerator): Response
    {
        return $this->getResponse('letter', $shapeLetterGenerator);
    }

    #[Route('/randomizer/rooms', name: 'randomizer_rooms', methods: ['GET'])]
    public function rooms(RoomsGenerator $roomsGenerator): Response
    {
        return $this->getResponse('rooms', $roomsGenerator);
    }

    #[Route('/randomizer/budget', name: 'randomizer_budget', methods: ['GET'])]
    public function budget(BudgetGenerator $budgetGenerator): Response
    {
        return $this->getResponse('budget', $budgetGenerator);
    }

    #[Route('/randomizer/buildings', name: 'randomizer_buildings', methods: ['GET'])]
    public function buildings(BuildingsGenerator $buildingsGenerator): Response
    {
        return $this->getResponse('buildings', $buildingsGenerator);
    }

    #[Route('/randomizer/colors', name: 'randomizer_colors', defaults: ['number' => 0], methods: ['GET'])]
    public function colors(ColorsGenerator $colorsGenerator, Request $request, int $number): Response
    {
        if (!$this->checkConfiguration('colors')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        $result = $colorsGenerator->setNumber($request->query->get('number') ?? $number)->getRandom();
        $result = $this->formatItem('colors', implode(", ", $result));
        $result->required = "rooms";

        return $this->json($result);
    }

    private function getResponse(string $name, Randomizer $randomizer): JsonResponse
    {
        if (!$this->checkConfiguration($name)) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->formatItem($name, $randomizer->getRandom()));
    }

    private function checkConfiguration(string $name): bool
    {
        $randomizers = $this->getParameter('generator.randomizers.list');

        return in_array($name, $randomizers);
    }

    private function formatItem(string $key, $value): stdClass
    {
        $form = new stdClass();
        $form->title = $key;
        $form->result = $value;
        if ($value) {
            $entity = $this->repository->createResult($key, $value);
            $form->id = $entity->getId();
        }

        return $form;
    }
}
