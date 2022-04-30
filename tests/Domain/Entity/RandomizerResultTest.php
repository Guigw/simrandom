<?php

namespace Yrial\Simrandom\Tests\Domain\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class RandomizerResultTest extends TestCase
{

    use ProphecyTrait;

    public function testGetId()
    {
        $reflectionClass = new ReflectionClass(RandomizerResult::class);
        $entity = new RandomizerResult();
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setValue($entity, 42);
        $this->assertEquals(42, $entity->getId());
    }

    public function testGetSavedChallenge()
    {
        $entity = new RandomizerResult();
        $entity->setSavedChallenge($this->prophesize(SavedChallenge::class)->reveal());
        $this->assertInstanceOf(SavedChallenge::class, $entity->getSavedChallenge());
    }

    public function testGetRollingDate()
    {
        $entity = new RandomizerResult();
        $this->assertInstanceOf(DateTimeImmutable::class, $entity->setRollingDate()->getRollingDate());
    }

    public function testGetName()
    {
        $entity = new RandomizerResult();
        $this->assertEquals('coucou', $entity->setName('coucou')->getName());
    }

    public function testGetResult()
    {
        $entity = new RandomizerResult();
        $this->assertEquals('coucou', $entity->setResult('coucou')->getResult());
    }
}
