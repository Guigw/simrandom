<?php

namespace Yrial\Simrandom\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Yrial\Simrandom\Domain\Contract\Repository\TryRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\ChallengeTry;
use Yrial\Simrandom\Domain\Entity\Draw;

class ChallengeRepositoryDoctrineAdapter extends ServiceEntityRepository implements TryRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChallengeTry::class);
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
     * @param ChallengeTry $challengeTry
     * @param array $randomizerResults
     * @return ChallengeTry
     */
    public function saveChallenge(ChallengeTry $challengeTry, array $randomizerResults): ChallengeTry
    {
        $this->_em->persist($challengeTry);
        /** @var Draw $randomizerResult */
        foreach ($randomizerResults as $randomizerResult) {
            $randomizerResult->setTry($challengeTry);
            $this->_em->persist($randomizerResult);
        }
        $this->_em->flush();
        return $challengeTry;
    }

    public function load(string $id): ?ChallengeTry
    {
        return $this->find($id);
    }
}
