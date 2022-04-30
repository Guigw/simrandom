<?php

namespace Yrial\Simrandom\Domain\ValueObject;

use Traversable;

class Randomizers implements \IteratorAggregate, \Countable
{

    private array $randomizers;

    public function __construct(Randomizer ...$randomizers)
    {
        $this->randomizers = $randomizers;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->randomizers);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->randomizers);
    }
}