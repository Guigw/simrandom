<?php

namespace Yrial\Simrandom;

class View
{
    public function render(array $params)
    {
        echo "
            <html lang='fr'>
                <body>
                    <h1>Sims Randomizer</h1>
                    " . array_reduce($params, function (string $carry, object $item): string
                        {
                            $carry .= $this->getRandomItem($item);
                            return $carry;
                        }, "") . "
                </body>
            </html>
        ";
    }

    private function getRandomItem(object $item): string
    {
        return "
            <div>
                <h2>$item->title</h2>
                <p>" . (is_array($item->result) ? implode(", ", $item->result) : $item->result) . "</p>
            </div>
        ";
    }

}