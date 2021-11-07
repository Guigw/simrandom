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
        if (!is_a($entity, $this->getEntity())) {
            throw new BadOutputMapperException($this->getDTO(), $this->getEntity(), get_class($entity));
        }

        $dto = new Result();
        return $dto->setId($entity->getId())
            ->setTitle($entity->getName())
            ->setResult($entity->getResult());
    }

    public function getEntity(): string
    {
        return RandomizerResult::class;
    }

    public function getDTO(): string
    {
        return Result::class;
    }
}