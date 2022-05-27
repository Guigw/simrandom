<?php

namespace Yrial\Simrandom\Domain\Exception;

use Exception;

class EmptyResultException extends Exception
{
    public function __construct(string $title)
    {
        parent::__construct("cannot register empty result");
    }
}