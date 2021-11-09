<?php

namespace Yrial\Simrandom\Tests\DTO;

use PHPUnit\Framework\TestCase;
use Yrial\Simrandom\DTO\Result;

class ResultTest extends TestCase
{

    public function testSetRequired()
    {
        $data = new Result();
        $this->assertEquals('coucou', $data->setRequired('coucou')->getRequired());
    }

    public function testSetId()
    {
        $data = new Result();
        $this->assertEquals(42, $data->setId(42)->getId());
    }

    public function testSetTitle()
    {
        $data = new Result();
        $this->assertEquals('coucou', $data->setTitle('coucou')->getTitle());
    }

    public function testSetResult()
    {
        $data = new Result();
        $this->assertEquals('coucou', $data->setResult('coucou')->getResult());
    }

    public function testJsonSerialize()
    {
        $data = new Result();
        $data->setResult('result')
            ->setId(42)
            ->setTitle('title')
            ->setRequired('required');
        $expected = [
            'id' => 42,
            'result' => 'result',
            'title' => 'title',
            'required' => 'required'
        ];
        $this->assertEquals($expected, $data->jsonSerialize());
    }

    public function testMinimumJsonSerialize()
    {
        $data = new Result();
        $data->setResult('result')
            ->setTitle('title');
        $expected = [
            'result' => 'result',
            'title' => 'title'
        ];
        $this->assertEquals($expected, $data->jsonSerialize());
    }
}
