<?php

namespace Yrial\Simrandom\Reader;
use Exception;
use SimpleXMLElement;
class ConfigReader
{
    private $config;

    /**
     * @throws Exception
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getRoomsParam(string $name): ?int {
        if (property_exists($this->config->rooms, $name)) {
            return (int)$this->config->rooms->$name[0];
        } else {
            return null;
        }
    }

    public function getBudgetParam(string $name): ?int {
        if (property_exists($this->config->budget, $name)) {
            return (int)$this->config->budget->$name[0];
        } else {
            return null;
        }
    }

    public function getColorsParams(): array {
        $results = [];
        foreach ($this->config->colors->color as $color) {
            for($i=0;$i<$color->weight;$i++) {
                $results[] = (string)$color->name;
            }
        }
        return $results;
    }

    public function getBuildingsList(): array {
        $results = [];
        foreach ($this->config->buildings->building as $building) {
            $results[] = (string)$building;
        }
        return $results;
    }
}