<?php

namespace Yrial\Simrandom\Application\Dto\Error;

class RandomizerMissingArgsDto
{
    /**
     * @var $args string[]
     */
    public function __construct(public readonly array $args
    )
    {

    }
}
