<?php

namespace Yrial\Simrandom\Application\Dto\Error;

class ChallengeNotFoundDto
{
    public function __construct(public readonly string $message
    )
    {

    }
}
