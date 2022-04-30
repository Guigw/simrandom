<?php

namespace Yrial\Simrandom\Tests\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class SavedChallengeTest extends TestCase
{
    use ProphecyTrait;

    public function testRemoveResult()
    {
        $entity = new SavedChallenge();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $reflectionProperty = $reflectionClass->getProperty('results');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(RandomizerResult::class);
        $new->getId()->willReturn(4);
        $new->setSavedChallenge(Argument::any())->shouldBeCalledTimes(2);
        $new->getSavedChallenge()->shouldBeCalledOnce()->willReturn($entity);
        $this->assertInstanceOf(SavedChallenge::class, $entity->addResult($new->reveal()));
        $this->assertInstanceOf(SavedChallenge::class, $entity->removeResult($new->reveal()));
        $this->assertCount(3, $entity->getResults());
    }

    public function testRemoveResultNotSaved()
    {
        $entity = new SavedChallenge();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $reflectionProperty = $reflectionClass->getProperty('results');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(RandomizerResult::class);
        $new->getId()->willReturn(4);
        $new->setSavedChallenge(Argument::type(SavedChallenge::class))->shouldBeCalledOnce();
        $new->getSavedChallenge()->shouldBeCalledOnce();
        $this->assertInstanceOf(SavedChallenge::class, $entity->addResult($new->reveal()));
        $this->assertInstanceOf(SavedChallenge::class, $entity->removeResult($new->reveal()));
        $this->assertCount(3, $entity->getResults());
    }

    public function testRemoveUnExistingResult()
    {
        $entity = new SavedChallenge();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $reflectionProperty = $reflectionClass->getProperty('results');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(RandomizerResult::class);
        $new->getId()->willReturn(4);
        $new->setSavedChallenge(Argument::type(SavedChallenge::class))->shouldNotBeCalled();
        $new->getSavedChallenge()->shouldNotBeCalled();
        $this->assertInstanceOf(SavedChallenge::class, $entity->removeResult($new->reveal()));
        $this->assertCount(3, $entity->getResults());
    }

    public function testGetName()
    {
        $entity = new SavedChallenge();
        $this->assertEquals('coucou', $entity->setName('coucou')->getName());
    }

    public function testGetId()
    {
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $entity = new SavedChallenge();
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setValue($entity, 42);
        $this->assertEquals(42, $entity->getId());
    }

    public function testGetResults()
    {
        $entity = new SavedChallenge();
        $collection = new ArrayCollection([1, 2, 3]);
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $reflectionProperty = $reflectionClass->getProperty('results');
        $reflectionProperty->setValue($entity, $collection);
        $this->assertCount(3, $entity->getResults());
    }

    public function testGetSharingDate()
    {
        $entity = new SavedChallenge();
        $this->assertInstanceOf(DateTimeImmutable::class, $entity->setSharingDate()->getSharingDate());
    }

    public function testAddResult()
    {
        $entity = new SavedChallenge();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $reflectionProperty = $reflectionClass->getProperty('results');
        $reflectionProperty->setValue($entity, $collection);
        $new = $this->prophesize(RandomizerResult::class);
        $new->getId()->willReturn(4);
        $new->setSavedChallenge(Argument::type(SavedChallenge::class))->shouldBeCalledOnce();
        $this->assertInstanceOf(SavedChallenge::class, $entity->addResult($new->reveal()));
        $this->assertCount(4, $entity->getResults());
    }

    public function testAddDuplicateResult()
    {
        $entity = new SavedChallenge();
        $collection = new ArrayCollection(array_map([$this, 'createRandomizerResult'], [1, 2, 3]));
        $reflectionClass = new ReflectionClass(SavedChallenge::class);
        $reflectionProperty = $reflectionClass->getProperty('results');
        $reflectionProperty->setValue($entity, $collection);
        $this->assertInstanceOf(SavedChallenge::class, $entity->addResult($collection->first()));
        $this->assertCount(3, $entity->getResults());
    }

    public function createRandomizerResult(int $id): RandomizerResult
    {
        $mock = $this->prophesize(RandomizerResult::class);
        $mock->getId()
            ->willReturn($id);
        $mock->setSavedChallenge(Argument::type(SavedChallenge::class))->shouldNotBeCalled();
        return $mock->reveal();
    }
}
