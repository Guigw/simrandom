<?php

namespace Yrial\Simrandom\Application\Dto\Error;

class UnknownRandomizerDto
{
    public function __construct(
        public readonly string $title
    )
    {

    }
}
