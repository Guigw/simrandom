<?php

namespace Yrial\Simrandom;

use Yrial\Simrandom\Generator\CharGenerator;
use Yrial\Simrandom\Generator\ColorsGenerator;
use Yrial\Simrandom\Generator\IntGenerator;
use Yrial\Simrandom\Generator\Randomizer;
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
        $this->view->render($this->getRandomness());
    }

    public function getRandomness(): array
    {
        $randomness = [];
        $randomness["pièces"] = (new IntGenerator($this->config->getRoomsParam("min"), $this->config->getRoomsParam("max")))->getRandom();
        $randomness["budget"] = (new IntGenerator($this->config->getBudgetParam("min"), $this->config->getBudgetParam("max")))->getRandom();
        $randomness["forme"] = (new CharGenerator())->getRandom();
        $randomness["couleurs"] = (new ColorsGenerator($randomness["pièces"], $this->config->getColorsParams()))->getRandom();
        return $this->formatItems($randomness);
    }

    private function formatItems(array $rawData): array
    {
        return array_map(function (string $key, $value) {
            $form = new \stdClass();
            $form->title = $key;
            $form->result = $value;
            return $form;
        }, array_keys($rawData), $rawData);
    }
}