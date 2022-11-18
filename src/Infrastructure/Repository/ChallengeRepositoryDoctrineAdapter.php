<?php

namespace Yrial\Simrandom\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class ChallengeRepositoryDoctrineAdapter extends ServiceEntityRepository implements SavedChallengeRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedChallenge::class);
    }

    public function removeOldChallenge(\DateTimeImmutable $lastDay): void
    {
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.sharingDate <= :lastMonth')
            ->setParameter('lastMonth', $lastDay);

        $resultsToDelete = $qb->getQuery()->getResult();
        foreach ($resultsToDelete as $entity) {
            $this->_em->remove($entity);
        }
        $this->_em->flush();
    }

    /**
     * @param SavedChallenge $savedChallenge
     * @param array $randomizerResults
     * @return SavedChallenge
     */
    public function saveChallenge(SavedChallenge $savedChallenge, array $randomizerResults): SavedChallenge
    {
        $this->_em->persist($savedChallenge);
        /** @var RandomizerResult $randomizerResult */
        foreach ($randomizerResults as $randomizerResult) {
            $randomizerResult->setSavedChallenge($savedChallenge);
            $this->_em->persist($randomizerResult);
        }
        $this->_em->flush();
        return $savedChallenge;
    }

    public function load(string $id): ?SavedChallenge
    {
        return $this->find($id);
    }
}
