<?php

namespace Yrial\Simrandom\Application\Dto;

use IteratorAggregate;

abstract class AbstractCollectionDto
{
    public readonly MetaCollectionDto $meta;
    public readonly CollectionInterfaceDto $data;

    public function __construct(
        IteratorAggregate $collection
    )
    {
        $this->data = $this->getCollection($collection);
        $this->meta = new MetaCollectionDto($this->data);

    }

    abstract protected function getCollection(IteratorAggregate $collection): CollectionInterfaceDto;
}
