<?php

namespace Yrial\Simrandom\Tests\Domain\ValueObject\Configuration;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\ValueObject\Configuration\WeightedListConfiguration;

class WeightedListConfigurationTest extends TestCase
{

    public function testConfigure()
    {
        $params = [['name' => 'bleu', 'weight' => 3], ['name' => 'rouge', 'weight' => 2]];
        $conf = new WeightedListConfiguration();
        $conf->configure($params);
        $this->assertEquals(['bleu', 'bleu', 'bleu', 'rouge', 'rouge'], $conf->getPossibilities());
    }
}
