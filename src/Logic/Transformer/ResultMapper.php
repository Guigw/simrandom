<?php

namespace Yrial\Simrandom\Logic\Transformer;

use JsonSerializable;
use Yrial\Simrandom\DTO\Result;
use Yrial\Simrandom\Entity\RandomizerResult;
use Yrial\Simrandom\Exception\BadOutputMapperException;

class ResultMapper implements MapperInterface
{

    /**
     * @param $entity
     * @return JsonSerializable
     * @throws BadOutputMapperException
     */
    public function EntityToDTO($entity): JsonSerializable
    {
        if (!is_a($entity, self::getEntity())) {
            throw new BadOutputMapperException(self::getDTO(), self::getEntity(), get_class($entity));
        }

        $dto = new Result();
        return $dto->setId($entity->getId())
            ->setTitle($entity->getName())
            ->setResult($entity->getResult());
    }

    public static function getEntity(): string
    {
        return RandomizerResult::class;
    }

    public static function getDTO(): string
    {
        return Result::class;
    }
}