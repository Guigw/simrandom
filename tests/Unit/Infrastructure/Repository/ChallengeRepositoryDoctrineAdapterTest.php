<?php

namespace Yrial\Simrandom\Tests\Unit\Infrastructure\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Entity\Draw;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;
use Yrial\Simrandom\Infrastructure\Repository\ChallengeRepositoryDoctrineAdapter;

class ChallengeRepositoryDoctrineAdapterTest extends TestCase
{
    use ProphecyTrait;

    public function testRemoveOldChallenge()
    {
        $meta = $this->prophesize(ClassMetadata::class);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getClassMetadata(Argument::is(SavedChallenge::class))->willReturn($meta->reveal());
        $em->remove(Argument::any())->shouldBeCalledTimes(3);
        $em->flush()->shouldBeCalledOnce();
        $query = $this->prophesize(AbstractQuery::class);
        $query->getResult()->willReturn([new SavedChallenge(), new SavedChallenge(), new SavedChallenge()]);
        $queryB = $this->prophesize(QueryBuilder::class);
        $queryB->select(Argument::any())->willReturn($queryB);
        $queryB->from(Argument::any(), Argument::any(), Argument::any())->willReturn($queryB);
        $queryB->andWhere(Argument::any())->willReturn($queryB)->shouldBeCalledTimes(1);
        $queryB->setParameter(Argument::any(), Argument::any())->willReturn($queryB);
        $queryB->getQuery()->willReturn($query);

        $em->createQueryBuilder()->willReturn($queryB->reveal());

        $objectManager = $this->prophesize(ManagerRegistry::class);
        $objectManager->getManagerForClass(Argument::is(SavedChallenge::class))->willReturn($em->reveal());

        $repo = new ChallengeRepositoryDoctrineAdapter($objectManager->reveal());
        $date = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $repo->removeOldChallenge($date);
    }

    public function testSaveChallenge()
    {
        $meta = $this->prophesize(ClassMetadata::class);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getClassMetadata(Argument::is(SavedChallenge::class))->willReturn($meta->reveal());
        $em->persist(Argument::any())->shouldBeCalledTimes(3);
        $em->flush()->shouldBeCalledOnce();

        $objectManager = $this->prophesize(ManagerRegistry::class);
        $objectManager->getManagerForClass(Argument::is(SavedChallenge::class))->willReturn($em->reveal());

        $repo = new ChallengeRepositoryDoctrineAdapter($objectManager->reveal());
        $this->assertInstanceOf(SavedChallenge::class, $repo->saveChallenge(new SavedChallenge(), [new Draw(), new Draw()]));
    }

    public function testLoad()
    {
        $challenge = new SavedChallenge();
        $meta = $this->prophesize(ClassMetadata::class);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getClassMetadata(Argument::is(SavedChallenge::class))->willReturn($meta->reveal());
        $em->find(Argument::is(SavedChallenge::class), Argument::is("42"), Argument::any(), Argument::any())->shouldBeCalledTimes(1)
            ->willReturn($challenge);

        $objectManager = $this->prophesize(ManagerRegistry::class);
        $objectManager->getManagerForClass(Argument::is(SavedChallenge::class))->willReturn($em->reveal());
        $repo = new ChallengeRepositoryDoctrineAdapter($objectManager->reveal());
        $reflectionClass = new \ReflectionClass($repo);
        $reflectionProperty = $reflectionClass->getProperty('_entityName');
        $reflectionProperty->setValue($repo, SavedChallenge::class);
        $result = $repo->load(42);
        $this->assertInstanceOf(SavedChallenge::class, $result);
        $this->assertEquals($challenge, $result);
    }
}
