<?php

namespace Yrial\Simrandom\Generator;

class ColorsGenerator extends AbstractGenerator
{
    private $colorGenerators = [];

    function __construct(array $params)
    {
        foreach ($params as $color) {
            for ($i = 0; $i < $color['weight']; $i++) {
                $this->possibilities[] = (string)$color['name'];
            }
        }
    }

    public function setNumber(int $number): ColorsGenerator
    {
        $this->colorGenerators = [];
        for ($i = 0; $i < $number; $i++) {
            $this->colorGenerators[] = new StringGenerator($this->possibilities);
        }
        return $this;
    }

    public function getRandom()
    {
        return array_map(function (StringGenerator $colorGenerator) {
            return $colorGenerator->getRandom();
        }, $this->colorGenerators);
    }
}