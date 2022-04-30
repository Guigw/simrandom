<?php

namespace Yrial\Simrandom\Tests\Domain\Exception;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;

class RandomizerConfigurationNotFoundExceptionTest extends TestCase
{
    public function testItExists()
    {
        $this->assertInstanceOf(\Exception::class, new RandomizerConfigurationNotFoundException());
    }
}
