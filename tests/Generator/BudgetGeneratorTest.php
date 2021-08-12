<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\BudgetGenerator;
use PHPUnit\Framework\TestCase;

class BudgetGeneratorTest extends TestCase
{

    public function test__construct()
    {
        $params = ['min' => 1000, 'max' => 1000000];
        $generator = new BudgetGenerator($params);
        $result = $generator->getRandom();
        $this->assertGreaterThanOrEqual(1000, $result);
        $this->assertLessThanOrEqual(1000000, $result);
    }
}
