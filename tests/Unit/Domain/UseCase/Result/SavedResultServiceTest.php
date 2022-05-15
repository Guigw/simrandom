<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\UseCase\Result;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\UseCase\Result\ResultService;
use Yrial\Simrandom\Domain\UseCase\Result\SavedResultService;

class SavedResultServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGenerate()
    {
        $dto = new ResultResponseDto('pipoupi', ['riri', 'fifi', 'loulou']);
        $mockedService = $this->prophesize(ResultService::class);
        $mockedService->generate(Argument::is('pipoupi'))->shouldBeCalledOnce()->willReturn($dto);
        $result = new RandomizerResult();
        $ref = new \ReflectionProperty($result, 'id');
        $ref->setValue($result, 42);
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedRepo->save(Argument::is('pipoupi'), Argument::is('riri, fifi, loulou'))->willReturn($result);
        $service = new SavedResultService($mockedService->reveal(), $mockedRepo->reveal());
        $service->generate('pipoupi');
        $this->assertEquals(42, $dto->getId());
    }

    public function testSaveEmpty()
    {
        $dto = new ResultResponseDto('pipoupi', []);
        $mockedService = $this->prophesize(ResultService::class);
        $mockedService->generate(Argument::is('pipoupi'))->shouldBeCalledOnce()->willReturn($dto);
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedRepo->save(Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
        $service = new SavedResultService($mockedService->reveal(), $mockedRepo->reveal());
        $service->generate('pipoupi');
    }

    public function testItExists()
    {
        $mockedService = $this->prophesize(ResultService::class);
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $this->assertInstanceOf(SavedResultService::class, new SavedResultService($mockedService->reveal(), $mockedRepo->reveal()));
    }
}
