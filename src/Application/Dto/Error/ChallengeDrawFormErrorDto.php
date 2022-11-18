<?php

namespace Yrial\Simrandom\Application\Dto\Error;

class ChallengeDrawFormErrorDto
{
    public function __construct(
        public readonly string $errors
    ) {

    }

}
