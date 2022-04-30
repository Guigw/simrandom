<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\UseCase\Challenge;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Yrial\Simrandom\Domain\Contract\Repository\SavedChallengeRepositoryInterface;
use Yrial\Simrandom\Domain\Dto\SavedChallengeDto;
use Yrial\Simrandom\Domain\Entity\SavedChallenge;
use Yrial\Simrandom\Domain\UseCase\Challenge\SavedChallengeService;

class SavedChallengeServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testSave()
    {
        $mockedRepo = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $mockedRepo->saveChallenge(Argument::that(function (SavedChallenge $challenge) {
            return $challenge->getName() == 'pouet';
        }), Argument::that(function (array $results) {
            return count($results) == 1;
        }))->shouldBeCalledTimes(1);
        $service = new SavedChallengeService($mockedRepo->reveal());
        $service->save('pouet', ['titouti']);
    }

    public function testFind()
    {
        $challenge = new SavedChallenge();
        $challenge->setName('pipou');
        $mockedRepo = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $mockedRepo->load(Argument::is('42'))->willReturn($challenge);
        $service = new SavedChallengeService($mockedRepo->reveal());
        $this->assertInstanceOf(SavedChallengeDto::class, $service->find('42'));
    }

    public function testFindNotFound()
    {
        $mockedRepo = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $mockedRepo->load(Argument::is('42'))->willReturn(null);
        $service = new SavedChallengeService($mockedRepo->reveal());
        $this->assertNull($service->find('42'));
    }

    public function testItExists()
    {
        $mockedRepo = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $this->assertInstanceOf(SavedChallengeService::class, new SavedChallengeService($mockedRepo->reveal()));
    }

    public function testCleanResults()
    {
        $date = (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
        $mockedRepo = $this->prophesize(SavedChallengeRepositoryInterface::class);
        $mockedRepo->removeOldChallenge(Argument::that(function ($input) use ($date) {
            return $input->getTimestamp() == $date->getTimestamp();
        }))->shouldBeCalledTimes(1);
        $service = new SavedChallengeService($mockedRepo->reveal());
        $service->cleanResults();
    }
}
