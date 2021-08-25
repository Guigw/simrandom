<?php

namespace Yrial\Simrandom\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Yrial\Simrandom\Entity\RandomizerResult;
use Yrial\Simrandom\Entity\SavedChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SavedChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavedChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavedChallenge[]    findAll()
 * @method SavedChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavedChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedChallenge::class);
    }

    public function saveChallenge(string $name): SavedChallenge
    {
        $challenge = new SavedChallenge();
        $challenge->setName($name);
        $this->_em->persist($challenge);
        $this->_em->flush($challenge);
        return $challenge;
    }

    public function finishedChallenge(ArrayCollection $randomizerResults, SavedChallenge $savedChallenge): void
    {
        /** @var RandomizerResult $randomizerResult */
        foreach ($randomizerResults as $randomizerResult) {
            $randomizerResult->setSavedChallenge($savedChallenge);
            $this->_em->persist($randomizerResult);
        }
        $this->_em->flush($randomizerResults->toArray());
    }

    public function removeOldLinks(): void {
        $lastThreeMonth = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.sharingDate <= :lastMonth')
            ->setParameter('lastMonth', $lastThreeMonth);

        $resultsToDelete = $qb->getQuery()->getResult();
        foreach($resultsToDelete as $entity) {
            $this->_em->remove($entity);
        }
        $this->_em->flush();
    }

    // /**
    //  * @return SavedChallenge[] Returns an array of SavedChallenge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SavedChallenge
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
