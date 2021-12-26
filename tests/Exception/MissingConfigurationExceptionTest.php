<?php

namespace Yrial\Simrandom\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Exception\MissingConfigurationException;

class MissingConfigurationExceptionTest extends TestCase
{

    public function test__construct()
    {
        $e = new MissingConfigurationException('rourou');
        $this->assertStringContainsString('rourou', $e->getMessage());
    }
}
