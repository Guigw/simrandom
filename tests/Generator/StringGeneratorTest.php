<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\StringGenerator;
use PHPUnit\Framework\TestCase;

class StringGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $possibility = ['pipoupi', 'titouti', 'jijouji'];
        $generator = new StringGenerator($possibility);
        $this->assertTrue(in_array($generator->getRandom(), $possibility));
    }
}
