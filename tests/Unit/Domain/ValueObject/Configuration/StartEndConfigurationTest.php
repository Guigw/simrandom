<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\ValueObject\Configuration;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Configuration\StartEndConfiguration;

class StartEndConfigurationTest extends TestCase
{

    public function testConfigure()
    {
        $params = ['start' => 'E', 'end' => 'R'];
        $conf = new StartEndConfiguration();
        $conf->configure($params);
        $this->assertEquals(range('E', 'R'), $conf->getPossibilities());
    }
}
