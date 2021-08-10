<?php

namespace Yrial\Simrandom\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yrial\Simrandom\Generator\BudgetGenerator;
use Yrial\Simrandom\Generator\BuildingsGenerator;
use Yrial\Simrandom\Generator\CharGenerator;
use Yrial\Simrandom\Generator\ColorsGenerator;
use Yrial\Simrandom\Generator\IntGenerator;
use Yrial\Simrandom\Generator\Randomizer;
use Yrial\Simrandom\Generator\RoomsGenerator;
use Yrial\Simrandom\Generator\ShapeLetterGenerator;
use Yrial\Simrandom\Generator\StringGenerator;

class RandomizerController extends AbstractController
{
    /**
     * @Route("/randomizer/letter", name="randomizer_letter")
     */
    public function letter(ShapeLetterGenerator $shapeLetterGenerator): Response
    {
        if (!$this->checkConfiguration('letter')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->formatItem('letter', $this->getGenerator($shapeLetterGenerator, true)));
    }

    /**
     * @Route("/randomizer/rooms", name="randomizer_rooms")
     */
    public function rooms(RoomsGenerator $roomsGenerator): Response
    {
        if (!$this->checkConfiguration('rooms')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->formatItem('rooms', $this->getGenerator($roomsGenerator, true)));
    }

    /**
     * @Route("/randomizer/budget", name="randomizer_budget")
     */
    public function budget(BudgetGenerator $budgetGenerator): Response
    {
        if (!$this->checkConfiguration('budget')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->formatItem('budget', $this->getGenerator($budgetGenerator, true)));
    }

    /**
     * @Route("/randomizer/buildings", name="randomizer_buildings")
     */
    public function buildings(BuildingsGenerator $buildingsGenerator): Response
    {
        if (!$this->checkConfiguration('buildings')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($this->formatItem('buildings', $this->getGenerator($buildingsGenerator, true)));
    }

    /**
     * @Route("/randomizer/colors", name="randomizer_colors", defaults={"number": 0}))
     */
    public function colors(int $number, ColorsGenerator $colorsGenerator, Request $request): Response
    {
        if (!$this->checkConfiguration('colors')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
        $number = $request->query->get('number') ?? 0;
        $result = array_map(function (array $color) {
            return $color['name'];
        }, $this->getGenerator($colorsGenerator->setNumber($number), true));

        $result = $this->formatItem('colors', implode(", ", $result));
        $result->required = "rooms";
        return $this->json($result);
    }

    private function getGenerator(Randomizer $generator, $active)
    {
        if ($active) {
            return $generator->getRandom();
        } else {
            return null;
        }
    }

    private function formatItems(array $rawData): array
    {
        return array_map([$this, "formatItem"], array_keys($rawData), $rawData);
    }

    private function formatItem(string $key, $value): \stdClass
    {
        $form = new \stdClass();
        $form->title = $key;
        $form->result = $value ?? '';
        //$form->active = (bool)$value;
        return $form;
    }

    private function checkConfiguration(string $name): bool
    {
        $randomizers = $this->getParameter('generator.randomizers.list');
        return (in_array($name, array_keys($randomizers)));
    }
}
