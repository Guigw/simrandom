<?php

namespace Yrial\Simrandom\Application\Dto\Randomizer;

use ArrayIterator;
use Traversable;
use Yrial\Simrandom\Application\Dto\CollectionInterfaceDto;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class RandomizerListDto implements CollectionInterfaceDto
{
    public readonly array $list;

    public function __construct(
        private readonly Randomizers $randomizers
    )
    {
        $this->list = array_map([$this, 'entityToDto'], iterator_to_array($this->randomizers->getIterator()));
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->list);
    }

    /**
     * @param Randomizer $rando
     * @return RandomizerDto
     */
    private function entityToDto(Randomizer $rando): RandomizerDto
    {
        return new RandomizerDto($rando);
    }
}
