<?php

namespace Yrial\Simrandom\Logic\Transformer;

use JsonSerializable;
use Yrial\Simrandom\DTO\SavedChallenge as SavedChallengeResults;
use Yrial\Simrandom\Entity\SavedChallenge;
use Yrial\Simrandom\Exception\BadOutputMapperException;

class SavedChallengeResultsMapper implements MapperInterface
{

    public function __construct(
        private ResultMapper $resultMapper
    )
    {
    }

    /**
     * @param SavedChallenge $entity
     *
     * @return SavedChallengeResults
     * @throws BadOutputMapperException
     */
    public function EntityToDTO($entity): JsonSerializable
    {
        if (!is_a($entity, self::getEntity())) {
            throw new BadOutputMapperException(self::getDTO(), self::getEntity(), get_class($entity));
        }

        $dto = new SavedChallengeResults();
        return $dto->setId($entity->getId())
            ->setName($entity->getName())
            ->setRandomizers(array_map(function ($resultEntity) {
                    return $this->resultMapper->EntityToDTO($resultEntity);
                }, $entity->getResults()->toArray())
            );
    }

    public static function getEntity(): string
    {
        return SavedChallenge::class;
    }

    public static function getDTO(): string
    {
        return SavedChallengeResults::class;
    }
}