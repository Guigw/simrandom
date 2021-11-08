<?php

namespace Yrial\Simrandom\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Attribute\Configuration;
use Yrial\Simrandom\Generator\BudgetGenerator;
use Yrial\Simrandom\Generator\BuildingsGenerator;
use Yrial\Simrandom\Generator\ColorsGenerator;
use Yrial\Simrandom\Generator\RoomsGenerator;
use Yrial\Simrandom\Generator\ShapeLetterGenerator;

class RandomizerController extends AbstractController
{
    #[Route('/randomizer/letter', name: 'randomizer_letter', methods: ['GET'])]
    #[Configuration('letter')]
    public function letter(ShapeLetterGenerator $shapeLetterGenerator): string
    {
        return $shapeLetterGenerator->getRandom();
    }

    #[Route('/randomizer/rooms', name: 'randomizer_rooms', methods: ['GET'])]
    #[Configuration('rooms')]
    public function rooms(RoomsGenerator $roomsGenerator): string
    {
        return $roomsGenerator->getRandom();
    }

    #[Route('/randomizer/budget', name: 'randomizer_budget', methods: ['GET'])]
    #[Configuration('budget')]
    public function budget(BudgetGenerator $budgetGenerator): string
    {
        return $budgetGenerator->getRandom();
    }

    #[Route('/randomizer/buildings', name: 'randomizer_buildings', methods: ['GET'])]
    #[Configuration('buildings')]
    public function buildings(BuildingsGenerator $buildingsGenerator): string
    {
        return $buildingsGenerator->getRandom();
    }

    #[Route('/randomizer/colors', name: 'randomizer_colors', defaults: ['number' => 0], methods: ['GET'])]
    #[Configuration('colors', 'rooms')]
    public function colors(ColorsGenerator $colorsGenerator, Request $request, int $number): string
    {
        $result = $colorsGenerator->setNumber($request->query->get('number') ?? $number)->getRandom();
        return implode(", ", $result);
    }
}
