<?php

namespace Yrial\Simrandom;

use Yrial\Simrandom\Generator\CharGenerator;
use Yrial\Simrandom\Generator\ColorsGenerator;
use Yrial\Simrandom\Generator\IntGenerator;
use Yrial\Simrandom\Generator\Randomizer;
use Yrial\Simrandom\Generator\StringGenerator;
use Yrial\Simrandom\Reader\ConfigReader;

class Controller
{
    private View $view;

    private ConfigReader $config;

    public function __construct(ConfigReader $config)
    {
        $this->view = new View();
        $this->config = $config;
    }

    public function generateRender()
    {
        $this->view->render([
            'random' => microtime(),
            'items' =>$this->getRandomness(array_keys($_POST))
        ]);
    }

    public function getRandomness(array $forms): array
    {
        $randomness = [];
        $randomness["pièces"] = $this->getGenerator(new IntGenerator($this->config->getRoomsParam("min"), $this->config->getRoomsParam("max")), in_array("pièces", $forms));
        $randomness["bâtiment"] = $this->getGenerator(new StringGenerator($this->config->getBuildingsList()), in_array("bâtiment", $forms));
        $randomness["budget"] = $this->getGenerator(new IntGenerator($this->config->getBudgetParam("min"), $this->config->getBudgetParam("max")), in_array("budget", $forms));
        $randomness["forme"] = $this->getGenerator(new CharGenerator(), in_array("forme", $forms));
        $randomness["couleurs"] = $this->getGenerator(new ColorsGenerator($randomness["pièces"] ?? 0, $this->config->getColorsParams()), in_array("couleurs", $forms));
        return $this->formatItems($randomness);
    }

    private function getGenerator(Randomizer $generator, $active) {
        if ($active) {
            return $generator->getRandom();
        } else {
            return null;
        }
    }

    private function formatItems(array $rawData): array
    {
        return array_map(function (string $key, $value) {
            $form = new \stdClass();
            $form->title = $key;
            $form->result = $value ?? '';
            $form->active = (bool)$value;
            return $form;
        }, array_keys($rawData), $rawData);
    }
}