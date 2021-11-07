<?php

namespace Yrial\Simrandom\Logic\Transformer;

use JsonSerializable;

/**
 * @property JsonSerializable $dto;
 * @property object $entity
 */
interface MapperInterface
{
    public function getDTO(): string;

    public function getEntity(): string;

    //public function DTOToEntity(JsonSerializable $dto);

    public function EntityToDTO($entity): JsonSerializable;
}