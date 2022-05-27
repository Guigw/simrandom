<?php
namespace Yrial\Simrandom\Tests\Unit\Domain\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use ReflectionMethod;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;
use Yrial\Simrandom\Domain\Exception\EmptyResultException;

class RandomizerResultTest extends TestCase
{

    use ProphecyTrait;

    public function testConstruct()
    {
        $date = new DateTimeImmutable();
        $entity = new RandomizerResult($date);
        $this->assertEquals($date, $entity->getRollingDate());
    }

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
        $date = new DateTimeImmutable();
        $entity = new RandomizerResult($date);
        $this->assertInstanceOf(DateTimeImmutable::class, $entity->getRollingDate());
        $this->assertEquals($date, $entity->getRollingDate());
    }

    public function testGetName()
    {
        $entity = new RandomizerResult();
        $this->assertEquals('coucou', $entity->setName('coucou')->getName());
    }

    public function testGetResults()
    {
        $entity = new RandomizerResult();
        $this->assertEquals(['coucou', 'c\'est moi'], $entity->pushResults(['coucou', 'c\'est moi'])->getResults());
    }

    public function testGetEmptyResult()
    {
        $entity = new RandomizerResult();
        $this->assertEquals([], $entity->getResults());
    }

    public function testPushEmptyResults()
    {
        $this->expectException(EmptyResultException::class);
        $entity = new RandomizerResult();
        $this->assertEquals([], $entity->pushResults([]));
    }

    public function testGetResultEmpty()
    {
        $this->expectException(EmptyResultException::class);
        $entity = new RandomizerResult();
        $entity->pushResults([]);
    }

    public function testGetResult()
    {
        $entity = new RandomizerResult();
        $methodGet = new ReflectionMethod($entity, 'getResult');
        $methodSet = new ReflectionMethod($entity, 'setResult');
        $methodSet->invoke($entity, 'pouet');
        $this->assertEquals('pouet', $methodGet->invoke($entity));
    }
}
