<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Dto;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Application\Dto\Draw\DrawDto;
use Yrial\Simrandom\Domain\Generator\Generators;

class ResultResponseDtoTest extends TestCase
{

    public function test__construct()
    {
        $dto = new DrawDto('title', ['titouti', 'pipoupi']);
        $this->assertInstanceOf(DrawDto::class, $dto);
    }

    public function testGetId()
    {
        $dto = new DrawDto('title', ['titouti', 'pipoupi'], [], 43);
        $this->assertEquals(43, $dto->getId());
        $this->assertEquals(42, $dto->setId(42)->getId());
    }

    public function testArrayParamsToString()
    {
        $dto = new DrawDto('title', ['titouti', 'pipoupi']);
        $this->assertEquals('titouti, pipoupi', DrawDto::arrayParamsToString($dto->results));
    }

    public function testJsonSerialize()
    {
        $dto = new DrawDto('title', ['titouti', 'pipoupi'], [Generators::Rooms->value, Generators::Shape->value], 43);
        $json = $dto->jsonSerialize();
        $this->assertEquals('title', $json['title']);
        $this->assertEquals('titouti, pipoupi', $json['result']);
        $this->assertEquals('rooms, letter', $json['required']);
        $this->assertEquals(43, $json['id']);
    }
}
