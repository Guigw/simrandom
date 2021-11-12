<?php

namespace Yrial\Simrandom\Logic\Transformer;

use JsonSerializable;

/**
 * @property JsonSerializable $dto;
 * @property object $entity
 */
interface MapperInterface
{
    public static function getDTO(): string;

    public static function getEntity(): string;

    public function EntityToDTO($entity): JsonSerializable;
}