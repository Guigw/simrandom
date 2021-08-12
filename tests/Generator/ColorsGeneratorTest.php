<?php

namespace Yrial\Simrandom\Tests\Generator;

use Yrial\Simrandom\Generator\ColorsGenerator;
use PHPUnit\Framework\TestCase;

class ColorsGeneratorTest extends TestCase
{

    private $possibilities = [['weight' => 2, 'name' => 'rouge'], ['weight' => 3, 'name' => 'bleu'], ['weight' => 1, 'name' => 'blanc']];

    public function test__construct()
    {
        $generator = new ColorsGenerator($this->possibilities);
        $this->assertEmpty($generator->getRandom());

        $generator->setNumber(5);
        $result = $generator->getRandom();
        $this->assertCount(5, $result);
        $this->assertEmpty(array_diff($result, array_map(function ($poss) {
            return $poss['name'];
        }, $this->possibilities)));
    }
}
