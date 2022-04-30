<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\ValueObject\Configuration;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Configuration\MinMaxConfiguration;

class MinMaxConfigurationTest extends TestCase
{

    public function testGetPossibilities()
    {
        $params = ['min' => 3, 'max' => 15];
        $conf = new MinMaxConfiguration();
        $conf->configure($params);
        $this->assertEquals(range(3, 15), $conf->getPossibilities());
    }
}
