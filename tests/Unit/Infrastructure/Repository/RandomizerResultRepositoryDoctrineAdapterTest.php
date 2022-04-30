<?php

namespace Yrial\Simrandom\Tests\Unit\Infrastructure\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Infrastructure\Repository\RandomizerResultRepositoryDoctrineAdapter;

class RandomizerResultRepositoryDoctrineAdapterTest extends KernelTestCase
{

    use ProphecyTrait;

    public function testSave()
    {
        $meta = $this->prophesize(ClassMetadata::class);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getClassMetadata(Argument::is(RandomizerResult::class))->willReturn($meta->reveal());
        $em->persist(Argument::type(RandomizerResult::class))->shouldBeCalledOnce();
        $em->flush(Argument::type(RandomizerResult::class))->shouldBeCalledOnce();

        $objectManager = $this->prophesize(ManagerRegistry::class);
        $objectManager->getManagerForClass(Argument::is(RandomizerResult::class))->willReturn($em->reveal());


        $repo = new RandomizerResultRepositoryDoctrineAdapter($objectManager->reveal());
        $result = $repo->save('pouic', 'pic');
        $this->assertInstanceOf(RandomizerResult::class, $result);
        $this->assertEquals('pouic', $result->getName());
        $this->assertEquals('pic', $result->getResult());
    }

    public function testRemoveUnusedResult()
    {
        $meta = $this->prophesize(ClassMetadata::class);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getClassMetadata(Argument::is(RandomizerResult::class))->willReturn($meta->reveal());
        $em->remove(Argument::any())->shouldBeCalledTimes(3);
        $em->flush()->shouldBeCalledOnce();
        $query = $this->prophesize(AbstractQuery::class);
        $query->getResult()->willReturn([1, 2, 3]);
        $queryB = $this->prophesize(QueryBuilder::class);
        $queryB->select(Argument::any())->willReturn($queryB);
        $queryB->from(Argument::any(), Argument::any(), Argument::any())->willReturn($queryB);
        $queryB->andWhere(Argument::any())->willReturn($queryB)->shouldBeCalledTimes(2);
        $queryB->setParameter(Argument::any(), Argument::any())->willReturn($queryB);
        $queryB->getQuery()->willReturn($query);

        $em->createQueryBuilder()->willReturn($queryB->reveal());

        $objectManager = $this->prophesize(ManagerRegistry::class);
        $objectManager->getManagerForClass(Argument::is(RandomizerResult::class))->willReturn($em->reveal());

        $repo = new RandomizerResultRepositoryDoctrineAdapter($objectManager->reveal());
        $date = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $repo->removeUnusedResult($date);
    }
}
