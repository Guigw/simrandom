<?php

namespace Yrial\Simrandom\Domain\Query\Draw;

use Yrial\Simrandom\Domain\Command\BaseCommand;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Domain\Generator\AbstractGenerator;
use Yrial\Simrandom\Domain\Generator\Generators;

class DrawQuery extends BaseCommand
{
    public readonly AbstractGenerator $generator;

    public readonly Generators $type;

    public readonly array $params;

    /**
     * @param string $title
     * @param mixed ...$params
     * @throws RandomizerNotFoundException
     */
    public function __construct(string $title, mixed ...$params)
    {
        $this->type = $this->getGeneratorType($title);
        $this->generator = $this->type->getGenerator();
        $this->params = $params;
    }

    /**
     * @param string $title
     * @return Generators
     * @throws RandomizerNotFoundException
     */
    private function getGeneratorType(string $title): Generators
    {
        $generatorType = Generators::tryFrom($title);
        if (is_null($generatorType)) {
            throw new RandomizerNotFoundException();
        }
        return $generatorType;
    }
}
