<?php
namespace Yrial\Simrandom\Tests\Unit\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use Yrial\Simrandom\Domain\Entity\ChallengeTry;
use Yrial\Simrandom\Domain\Entity\Draw;

class ChallengeTryTest extends TestCase
{
    use ProphecyTrait;

    public function testConstruct()
    {
        $date = new DateTimeImmutable();
        $entity = new ChallengeTry($date);
        $this->assertEquals($date, $entity->getSharingDate());
    }

    public function testRemoveResult()
    {
        $entity = new ChallengeTry();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $reflectionProperty = $reflectionClass->getProperty('draws');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(Draw::class);
        $new->getId()->willReturn(4);
        $new->setTry(Argument::any())->shouldBeCalledTimes(2);
        $new->getTry()->shouldBeCalledOnce()->willReturn($entity);
        $this->assertInstanceOf(ChallengeTry::class, $entity->addDraw($new->reveal()));
        $this->assertInstanceOf(ChallengeTry::class, $entity->removeDraw($new->reveal()));
        $this->assertCount(3, $entity->getDraws());
    }

    public function testRemoveResultNotSaved()
    {
        $entity = new ChallengeTry();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $reflectionProperty = $reflectionClass->getProperty('draws');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(Draw::class);
        $new->getId()->willReturn(4);
        $new->setTry(Argument::type(ChallengeTry::class))->shouldBeCalledOnce();
        $new->getTry()->shouldBeCalledOnce();
        $this->assertInstanceOf(ChallengeTry::class, $entity->addDraw($new->reveal()));
        $this->assertInstanceOf(ChallengeTry::class, $entity->removeDraw($new->reveal()));
        $this->assertCount(3, $entity->getDraws());
    }

    public function testRemoveUnExistingResult()
    {
        $entity = new ChallengeTry();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $reflectionProperty = $reflectionClass->getProperty('draws');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(Draw::class);
        $new->getId()->willReturn(4);
        $new->setTry(Argument::type(ChallengeTry::class))->shouldNotBeCalled();
        $new->getTry()->shouldNotBeCalled();
        $this->assertInstanceOf(ChallengeTry::class, $entity->removeDraw($new->reveal()));
        $this->assertCount(3, $entity->getDraws());
    }

    public function testGetName()
    {
        $entity = new ChallengeTry();
        $this->assertEquals('coucou', $entity->setName('coucou')->getName());
    }

    public function testSetSharingDate()
    {
        $date = new DateTimeImmutable();
        $entity = new ChallengeTry();
        $this->assertEquals($date, $entity->setSharingDate($date)->getSharingDate());
    }


    public function testGetId()
    {
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $entity = new ChallengeTry();
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setValue($entity, 42);
        $this->assertEquals(42, $entity->getId());
    }

    public function testGetResults()
    {
        $entity = new ChallengeTry();
        $collection = new ArrayCollection([1, 2, 3]);
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $reflectionProperty = $reflectionClass->getProperty('draws');
        $reflectionProperty->setValue($entity, $collection);
        $this->assertCount(3, $entity->getDraws());
    }

    public function testGetSharingDate()
    {
        $date = new DateTimeImmutable();
        $entity = new ChallengeTry($date);
        $this->assertInstanceOf(DateTimeImmutable::class, $entity->getSharingDate());
        $this->assertEquals($date, $entity->getSharingDate());
    }

    public function testAddResult()
    {
        $entity = new ChallengeTry();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $reflectionProperty = $reflectionClass->getProperty('draws');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(Draw::class);
        $new->getId()->willReturn(4);
        $new->setTry(Argument::type(ChallengeTry::class))->shouldBeCalledOnce();
        $this->assertInstanceOf(ChallengeTry::class, $entity->addDraw($new->reveal()));
        $this->assertCount(4, $entity->getDraws());
    }

    public function testAddDuplicateResult()
    {
        $entity = new ChallengeTry();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(ChallengeTry::class);
        $reflectionProperty = $reflectionClass->getProperty('draws');
        $reflectionProperty->setValue($entity, $collection);
        $this->assertInstanceOf(ChallengeTry::class, $entity->addDraw($collection->first()));
        $this->assertCount(3, $entity->getDraws());
    }

    public function createRandomizerResult(int $id): Draw
    {
        $mock = $this->prophesize(Draw::class);
        $mock->getId()
            ->willReturn($id);
        $mock->setTry(Argument::type(ChallengeTry::class))->shouldNotBeCalled();
        return $mock->reveal();
    }
}
