<?php

namespace Yrial\Simrandom\Tests\Domain\UseCase\Result;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\UseCase\Result\ResultService;

class ResultServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGenerate()
    {
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedConfiguration->find(Argument::is('rooms'))->willReturn(['min' => 4, 'max' => 34]);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $mockedResultService->save(Argument::type(ResultResponseDto::class))->shouldBeCalledOnce();
        $service = new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal());
        $this->assertInstanceOf(ResultResponseDto::class, $service->generate('rooms'));
    }

    public function testItExists()
    {
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $this->assertInstanceOf(ResultService::class, new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal()));
    }
}
