<?php

namespace Yrial\Simrandom\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class OutputMapper
{
    public function __construct(
        public string $mapper)
    {
    }
}