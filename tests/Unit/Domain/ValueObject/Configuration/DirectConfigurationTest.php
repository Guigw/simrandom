<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\ValueObject\Configuration;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Configuration\DirectConfiguration;

class DirectConfigurationTest extends TestCase
{

    public function testConfigure()
    {
        $list = ['riri', 'fifi', 'loulou'];
        $conf = new DirectConfiguration();
        $conf->configure($list);
        $this->assertEquals($list, $conf->getPossibilities());
    }
}
