<?php

namespace Yrial\Simrandom\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Yrial\Simrandom\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{

    public function testGetConfigTreeBuilder()
    {
        $conf = new Configuration();
        $this->assertInstanceOf(TreeBuilder::class, $conf->getConfigTreeBuilder());
    }
}
