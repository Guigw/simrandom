<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Dto;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Application\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\Draw;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;

class SavedChallengeDtoTest extends TestCase
{

    public function test__construct()
    {
        $challenge = new SavedChallenge();
        $challenge->setName('lol');

        $ref = new \ReflectionProperty($challenge, 'id');
        $ref->setValue($challenge, 42);
        $dto = new SavedChallengeDto($challenge);
        $this->assertInstanceOf(SavedChallengeDto::class, $dto);
    }

    public function test__constructEmptyId()
    {
        $challenge = new SavedChallenge();
        $challenge->setName('lol');

        $dto = new SavedChallengeDto($challenge);
        $this->assertInstanceOf(SavedChallengeDto::class, $dto);
    }

    public function testJsonSerialize()
    {
        $result = new Draw();
        $ref = new \ReflectionProperty($result, 'id');
        $ref->setValue($result, 43);
        $result->setName('result');
        $result->pushResults(['pouet']);

        $challenge = new SavedChallenge();
        $challenge->setName('lol');
        $challenge->addResult($result);

        $ref = new \ReflectionProperty($challenge, 'id');
        $ref->setValue($challenge, 42);
        $dto = new SavedChallengeDto($challenge);
        $this->assertInstanceOf(SavedChallengeDto::class, $dto);
        $json = $dto->jsonSerialize();
        $this->assertEquals(42, $json['id']);
        $this->assertEquals('lol', $json['name']);
        $this->assertEquals(1, $json['count']);
        $this->assertEquals('result', $json['randomizers'][0]['title']);
        $this->assertEquals('pouet', $json['randomizers'][0]['result']);
        $this->assertEquals(43, $json['randomizers'][0]['id']);
    }
}
