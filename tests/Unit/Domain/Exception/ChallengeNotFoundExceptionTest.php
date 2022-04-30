<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\Exception;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Exception\ChallengeNotFoundException;

class ChallengeNotFoundExceptionTest extends TestCase
{
    public function testItExists()
    {
        $this->assertInstanceOf(\Exception::class, new ChallengeNotFoundException());
    }
}
