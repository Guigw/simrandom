<?php

namespace Yrial\Simrandom\Application\Exception;

use Exception;

class HandlerImplementationException extends Exception
{
    public function __construct(string $classname)
    {
        $message = "$classname doesn't not implements Yrial\Simrandom\Application\Contract\HandlerInterface";
        parent::__construct($message);
    }
}