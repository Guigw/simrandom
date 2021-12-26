<?php

namespace Yrial\Simrandom\Repository;

use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Yrial\Simrandom\Entity\RandomizerResult;

/**
 * @method RandomizerResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method RandomizerResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method RandomizerResult[]    findAll()
 * @method RandomizerResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RandomizerResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RandomizerResult::class);
    }

    public function createResult(string $key, string $value): RandomizerResult
    {
        $result = new RandomizerResult();
        $result->setName($key)
            ->setResult($value ?? '');
        $this->_em->persist($result);
        $this->_em->flush($result);
        return $result;
    }

    public function removeUnusedResult(): void
    {
        $lastDay = (new DateTimeImmutable())->sub(new DateInterval('P1D'));
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

    // /**
    //  * @return RandomizerResult[] Returns an array of RandomizerResult objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RandomizerResult
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
