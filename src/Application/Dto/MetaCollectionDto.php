<?php

namespace Yrial\Simrandom\Application\Dto;

class MetaCollectionDto
{
    public readonly int $count;

    public function __construct(CollectionInterfaceDto $collectionInterfaceDto)
    {
        $this->count = count($collectionInterfaceDto);
    }
}
