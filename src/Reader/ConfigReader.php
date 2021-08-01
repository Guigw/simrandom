<?php

namespace Yrial\Simrandom\Reader;
use Exception;
use SimpleXMLElement;
class ConfigReader
{
    private SimpleXMLElement $config;

    /**
     * @throws Exception
     */
    public function __construct(string $path)
    {
        if (file_exists($path)) {
            $this->config = simplexml_load_file($path);
        } else {
            throw new Exception('config file not found');
        }
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
        return array_map(function ($value) {
            return $value;
        }, (array)$this->config->colors->color);
    }
}