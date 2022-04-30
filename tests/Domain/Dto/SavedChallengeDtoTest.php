<?php

namespace Yrial\Simrandom\Tests\Domain\Dto;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
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

    public function testJsonSerialize()
    {
        $result = new RandomizerResult();
        $ref = new \ReflectionProperty($result, 'id');
        $ref->setValue($result, 43);
        $result->setName('result');
        $result->setResult('pouet');

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
