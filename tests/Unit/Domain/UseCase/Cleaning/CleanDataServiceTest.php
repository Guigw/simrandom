<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\UseCase\Cleaning;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Repository\RandomizerResultRepositoryInterface;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\UseCase\Cleaning\CleanDataService;

class CleanDataServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testCleanResults()
    {
        $dateChallenge = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $mockedSavedChallengeRepository = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $mockedSavedChallengeRepository->removeOldChallenge(Argument::that(function ($input) use ($dateChallenge) {
            return $input->getTimestamp() == $dateChallenge->getTimestamp();
        }))->shouldBeCalledTimes(1);

        $lastDay = (new \DateTimeImmutable())->sub(new \DateInterval('P1D'));
        $mockedRandomizerResultRepository = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $mockedRandomizerResultRepository->removeUnusedResult(Argument::that(function ($input) use ($lastDay) {
            return $input->getTimestamp() == $lastDay->getTimestamp();
        }))->shouldBeCalledOnce();

        $service = new CleanDataService($mockedSavedChallengeRepository->reveal(), $mockedRandomizerResultRepository->reveal());
        $service->cleanResults();
    }


    public function test__construct()
    {
        $mockedSavedChallengeRepository = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $mockedRandomizerResultRepository = $this->prophesize(RandomizerResultRepositoryInterface::class);
        $this->assertInstanceOf(CleanDataService::class, new CleanDataService($mockedSavedChallengeRepository->reveal(), $mockedRandomizerResultRepository->reveal()));
    }
}
