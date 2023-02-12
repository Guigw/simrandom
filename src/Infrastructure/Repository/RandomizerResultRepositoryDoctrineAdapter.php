<?php

namespace Yrial\Simrandom\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Entity\Draw;

class RandomizerResultRepositoryDoctrineAdapter extends ServiceEntityRepository
    implements RandomizerResultRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Draw::class);
    }

    public function save(Draw $result): Draw
    {
        $this->_em->persist($result);
        $this->_em->flush($result);
        return $result;
    }

    public function removeUnusedResult(\DateTimeImmutable $lastDay): void
    {
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.rollingDate <= :lastDay')
            ->andWhere('r.savedChallenge IS NULL')
            ->setParameter('lastDay', $lastDay);

        $resultsToDelete = $qb->getQuery()->getResult();
        foreach ($resultsToDelete as $entity) {
            $this->_em->remove($entity);
        }
        $this->_em->flush();
    }
}
