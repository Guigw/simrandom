<?php

namespace Yrial\Simrandom\Tests\Infrastructure\Configuration;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\Domain\Exception\RandomizerConfigurationNotFoundException;
use Yrial\Simrandom\Infrastructure\Configuration\RandomizerConfigurationAdapter;

class RandomizerConfigurationAdapterTest extends TestCase
{

    public function testFind()
    {
        $randoConf = new RandomizerConfigurationAdapter(['riri' => ['riri'], 'fifi' => ['fifi'], 'loulou' => ['loulou']]);
        $this->assertEquals(['riri'], $randoConf->find('riri'));
    }

    public function testFindNotFound()
    {
        $this->expectException(RandomizerConfigurationNotFoundException::class);
        $randoConf = new RandomizerConfigurationAdapter(['riri' => ['riri'], 'fifi' => ['fifi'], 'loulou' => ['loulou']]);
        $randoConf->find('lilouli');
    }
}
