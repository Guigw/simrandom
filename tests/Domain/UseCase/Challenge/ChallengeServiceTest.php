<?php

namespace Yrial\Simrandom\Tests\Domain\UseCase\Challenge;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Repository\ChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Dto\DetailChallengeResponseDto;
use Yrial\Simrandom\Domain\Dto\ListChallengeResponseDto;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\UseCase\Challenge\ChallengeService;
use Yrial\Simrandom\Domain\ValueObject\Challenge;
use Yrial\Simrandom\Domain\ValueObject\Randomizer;

class ChallengeServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testFind()
    {
        $challenge = new Challenge(4, 'name', new  Randomizer('random'));
        $mockedService = $this->prophesize(ChallengeRepositoryInterface::class);
        $mockedService->find(Argument::is(42))->willReturn($challenge);
        $service = new ChallengeService($mockedService->reveal());
        $result = $service->find(42);
        $this->assertInstanceOf(DetailChallengeResponseDto::class, $result);
    }

    public function testFindNotFound()
    {
        $this->expectException(ChallengeNotFoundException::class);
        $mockedService = $this->prophesize(ChallengeRepositoryInterface::class);
        $mockedService->find(Argument::is(42))->willThrow(new ChallengeNotFoundException());
        $service = new ChallengeService($mockedService->reveal());
        $service->find(42);
    }

    public function testGet()
    {
        $challenge1 = new Challenge(4, 'name', new  Randomizer('random'));
        $challenge2 = new Challenge(4, 'name', new  Randomizer('random'));
        $mockedService = $this->prophesize(ChallengeRepositoryInterface::class);
        $mockedService->get()->willReturn([$challenge1, $challenge2]);
        $service = new ChallengeService($mockedService->reveal());
        $result = $service->get();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(ListChallengeResponseDto::class, $result);
    }

    public function testItExists()
    {
        $mockedService = $this->prophesize(ChallengeRepositoryInterface::class);
        $this->assertInstanceOf(ChallengeService::class, new ChallengeService($mockedService->reveal()));
    }
}
