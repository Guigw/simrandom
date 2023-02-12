<?php
namespace Yrial\Simrandom\Tests\Unit\Domain\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use ReflectionClass;
use ReflectionMethod;
use Yrial\Simrandom\Domain\Entity\ChallengeTry;
use Yrial\Simrandom\Domain\Entity\Draw;
use Yrial\Simrandom\Domain\Exception\EmptyResultException;

class DrawTest extends TestCase
{

    use ProphecyTrait;

    public function testConstruct()
    {
        $date = new DateTimeImmutable();
        $entity = new Draw($date);
        $this->assertEquals($date, $entity->getRollingDate());
    }

    public function testGetId()
    {
        $reflectionClass = new ReflectionClass(Draw::class);
        $entity = new Draw();
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setValue($entity, 42);
        $this->assertEquals(42, $entity->getId());
    }

    public function testGetSavedChallenge()
    {
        $entity = new Draw();
        $entity->setTry($this->prophesize(ChallengeTry::class)->reveal());
        $this->assertInstanceOf(ChallengeTry::class, $entity->getTry());
    }

    public function testGetRollingDate()
    {
        $date = new DateTimeImmutable();
        $entity = new Draw($date);
        $this->assertInstanceOf(DateTimeImmutable::class, $entity->getRollingDate());
        $this->assertEquals($date, $entity->getRollingDate());
    }

    public function testGetName()
    {
        $entity = new Draw();
        $this->assertEquals('coucou', $entity->setName('coucou')->getName());
    }

    public function testGetResults()
    {
        $entity = new Draw();
        $this->assertEquals(['coucou', 'c\'est moi'], $entity->pushResults(['coucou', 'c\'est moi'])->getResults());
    }

    public function testGetEmptyResult()
    {
        $entity = new Draw();
        $this->assertEquals([], $entity->getResults());
    }

    public function testPushEmptyResults()
    {
        $this->expectException(EmptyResultException::class);
        $entity = new Draw();
        $this->assertEquals([], $entity->pushResults([]));
    }

    public function testGetResultEmpty()
    {
        $this->expectException(EmptyResultException::class);
        $entity = new Draw();
        $entity->pushResults([]);
    }

    public function testGetResult()
    {
        $entity = new Draw();
        $methodGet = new ReflectionMethod($entity, 'getResult');
        $methodSet = new ReflectionMethod($entity, 'setResult');
        $methodSet->invoke($entity, 'pouet');
        $this->assertEquals('pouet', $methodGet->invoke($entity));
    }
}
