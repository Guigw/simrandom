<?php

namespace Yrial\Simrandom\Tests\Domain\Dto;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;
use Yrial\Simrandom\Domain\ValueObject\Randomizers;

class DetailChallengeResponseDtoTest extends TestCase
{

    public function testJsonSerialize()
    {
        $dto = new DetailChallengeResponseDto(42, 'title', new Randomizers(new Randomizer('riri'), new Randomizer('fifi'), new Randomizer('loulou')));
        $json = $dto->jsonSerialize();
        $this->assertEquals('title', $json['name']);
        $this->assertEquals(42, $json['id']);
        $this->assertCount(3, $json['randomizers']);
    }

    public function test__construct()
    {
        $dto = new DetailChallengeResponseDto(42, 'title', new Randomizers(new Randomizer('riri'), new Randomizer('fifi'), new Randomizer('loulou')));
        $this->assertInstanceOf(DetailChallengeResponseDto::class, $dto);
    }
}
