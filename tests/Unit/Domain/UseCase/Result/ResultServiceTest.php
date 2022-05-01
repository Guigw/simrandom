<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\UseCase\Result;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Configuration\RandomizerConfigurationInterface;
use Yrial\Simrandom\Domain\Contract\UseCase\SavedResultServiceInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Exception\RandomizerNotFoundException;
use Yrial\Simrandom\Domain\UseCase\Result\ResultService;

class ResultServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGenerateUnknown()
    {
        $this->expectException(RandomizerNotFoundException::class);
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $service = new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal());
        $service->generate('titouti');
    }

    public function testGenerate()
    {
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedConfiguration->find(Argument::is('rooms'))->willReturn(['min' => 4, 'max' => 34]);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $mockedResultService->save(Argument::type(ResultResponseDto::class))->shouldBeCalledOnce();
        $service = new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal());
        $this->assertInstanceOf(ResultResponseDto::class, $service->generate('rooms'));
    }

    public function testGenerateDependenciesEmptyNumber()
    {
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedConfiguration->find(Argument::is('colors'))->willReturn([]);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $mockedResultService->save(Argument::type(ResultResponseDto::class))->shouldBeCalledOnce();
        $service = new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal());
        $response = $service->generate('colors');
        $this->assertInstanceOf(ResultResponseDto::class, $response);
        $this->assertEmpty($response->results);
    }

    public function testGenerateDependencies()
    {
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedConfiguration->find(Argument::is('colors'))->willReturn([['name' => 'rouge', 'weight' => 4]]);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $mockedResultService->save(Argument::type(ResultResponseDto::class))->shouldBeCalledOnce();
        $service = new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal());
        $response = $service->generate('colors', 4);
        $this->assertInstanceOf(ResultResponseDto::class, $response);
        $this->assertCount(4, $response->results);
    }

    public function testItExists()
    {
        $mockedConfiguration = $this->prophesize(RandomizerConfigurationInterface::class);
        $mockedResultService = $this->prophesize(SavedResultServiceInterface::class);
        $this->assertInstanceOf(ResultService::class, new ResultService($mockedConfiguration->reveal(), $mockedResultService->reveal()));
    }
}
