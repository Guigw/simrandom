<?php

namespace Yrial\Simrandom\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Exception\BadOutputMapperException;

class BadOutputMapperExceptionTest extends TestCase
{

    public function test__construct()
    {
        $e = new BadOutputMapperException('riri', 'fifi', 'loulou');
        $this->assertStringContainsString('riri', $e->getMessage());
        $this->assertStringContainsString('fifi', $e->getMessage());
        $this->assertStringContainsString('loulou', $e->getMessage());
    }
}
