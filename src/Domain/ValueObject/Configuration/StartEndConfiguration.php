<?php

namespace Yrial\Simrandom\Domain\ValueObject\Configuration;

use Yrial\Simrandom\Domain\Contract\Generator\GeneratorConfiguration;

class StartEndConfiguration implements GeneratorConfiguration
{
    private string $start;
    private string $end;

    /**
     * @param mixed $conf
     * @return void
     */
    public function configure(mixed $conf): void
    {
        $this->start = $conf['start'];
        $this->end = $conf['end'];
    }

    /**
     * @return array
     */
    public function getPossibilities(): array
    {
        return range($this->start, $this->end);
    }


}