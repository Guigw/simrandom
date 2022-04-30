<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Dto;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Dto\ListChallengeResponseDto;

class ListChallengeResponseDtoTest extends TestCase
{

    public function testJsonSerialize()
    {
        $dto = new ListChallengeResponseDto(42, 'title', 3);
        $json = $dto->jsonSerialize();
        $this->assertEquals('title', $json['name']);
        $this->assertEquals(42, $json['id']);
        $this->assertEquals(3, $json['count']);
    }

    public function test__construct()
    {
        $dto = new ListChallengeResponseDto(42, 'title', 3);
        $this->assertInstanceOf(ListChallengeResponseDto::class, $dto);
    }
}
