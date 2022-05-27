<?php

namespace Yrial\Simrandom\Tests\Unit\Application\Exception;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Application\Exception\HandlerImplementationException;

class HandlerImplementationExceptionTest extends TestCase
{

    public function test__construct()
    {
        $this->assertInstanceOf(HandlerImplementationException::class, new HandlerImplementationException('titouti'));
    }
}
