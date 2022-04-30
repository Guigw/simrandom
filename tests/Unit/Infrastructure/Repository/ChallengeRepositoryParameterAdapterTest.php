<?php

namespace Yrial\Simrandom\Tests\Unit\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;
use Yrial\Simrandom\Domain\ValueObject\Challenge;
use Yrial\Simrandom\Infrastructure\Repository\ChallengeRepositoryParameterAdapter;

class ChallengeRepositoryParameterAdapterTest extends TestCase
{

    public function testGet()
    {
        $challenges = [
            ['id' => 3, 'name' => 'construction', 'randomizers' => ['tu', 'ma']],
            ['id' => 4, 'name' => 'next', 'randomizers' => ['ma']],
        ];
        $repo = new ChallengeRepositoryParameterAdapter($challenges);
        $result = $repo->get();
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(Challenge::class, $result);
    }

    public function testFind()
    {
        $challenges = [
            ['id' => 3, 'name' => 'construction', 'randomizers' => ['tu', 'ma']],
            ['id' => 4, 'name' => 'next', 'randomizers' => ['ma']],
        ];
        $repo = new ChallengeRepositoryParameterAdapter($challenges);
        $result = $repo->find(3);
        $this->assertInstanceOf(Challenge::class, $result);
        $this->assertEquals(3, $result->getId());
    }

    public function testFindNotFound()
    {
        $this->expectException(ChallengeNotFoundException::class);
        $challenges = [
            ['id' => 3, 'name' => 'construction', 'randomizers' => ['tu', 'ma']],
            ['id' => 4, 'name' => 'next', 'randomizers' => ['ma']],
        ];
        $repo = new ChallengeRepositoryParameterAdapter($challenges);
        $repo->find(2);
    }
}
