<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\UseCase\Result;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Dto\ResultResponseDto;
use Yrial\Simrandom\Domain\Entity\RandomizerResult;
use Yrial\Simrandom\Domain\UseCase\Result\SavedResultService;

class SavedResultServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testSave()
    {
        $dto = new ResultResponseDto('pipoupi', ['riri', 'fifi', 'loulou']);
        $result = new RandomizerResult();
        $ref = new \ReflectionProperty($result, 'id');
        $ref->setValue($result, 42);
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedRepo->save(Argument::is('pipoupi'), Argument::is('riri, fifi, loulou'))->willReturn($result);
        $service = new SavedResultService($mockedRepo->reveal());
        $service->save($dto);
        $this->assertEquals(42, $dto->getId());
    }

    public function testSaveEmpty()
    {
        $dto = new ResultResponseDto('pipoupi', []);
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedRepo->save(Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
        $service = new SavedResultService($mockedRepo->reveal());
        $service->save($dto);
    }

    public function testCleanResults()
    {
        $lastDay = (new \DateTimeImmutable())->sub(new \DateInterval('P1D'));
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedRepo->removeUnusedResult(Argument::that(function ($input) use ($lastDay) {
            return $input->getTimestamp() == $lastDay->getTimestamp();
        }))->shouldBeCalledOnce();
        $service = new SavedResultService($mockedRepo->reveal());
        $service->cleanResults();
    }

    public function testItExists()
    {
        $mockedRepo = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $this->assertInstanceOf(SavedResultService::class, new SavedResultService($mockedRepo->reveal()));
    }
}
