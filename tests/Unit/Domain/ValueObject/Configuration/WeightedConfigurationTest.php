<?php

namespace Yrial\Simrandom\Tests\Unit\Domain\ValueObject\Configuration;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Configuration\WeightedConfiguration;

class WeightedConfigurationTest extends TestCase
{

    public function testConfigure()
    {
        $params = ['name' => 'bleu', 'weight' => 3];
        $conf = new WeightedConfiguration();
        $conf->configure($params);
        $this->assertEquals(['bleu', 'bleu', 'bleu'], $conf->getPossibilities());
    }
}
