<?php

namespace Yrial\Simrandom\Domain\ValueObject;

use ArrayIterator;
use Traversable;

class Randomizers implements \IteratorAggregate, \Countable
{

    private array $randomizers;
    public readonly int $count;

    public function __construct(Randomizer ...$randomizers)
    {
        $this->randomizers = $randomizers;
        $this->count = count($this->randomizers);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->randomizers);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->randomizers);
    }
}