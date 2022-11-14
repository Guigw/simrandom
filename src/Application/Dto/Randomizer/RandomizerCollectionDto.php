<?php

namespace Yrial\Simrandom\Application\Dto\Randomizer;

use IteratorAggregate;
use Yrial\Simrandom\Application\Dto\AbstractCollectionDto;
use Yrial\Simrandom\Application\Dto\CollectionInterfaceDto;

class RandomizerCollectionDto extends AbstractCollectionDto
{

    /**
     * @param IteratorAggregate $collection
     * @return CollectionInterfaceDto
     */
    protected function getCollection(IteratorAggregate $collection): CollectionInterfaceDto
    {
        return new RandomizerListDto($collection);
    }
}
