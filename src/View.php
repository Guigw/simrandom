<?php

namespace Yrial\Simrandom;

class View
{
    public function render(array $params)
    {
        echo "
            <form method='post' action='./index.php?alea=".$params['random']."'>
            " . array_reduce($params['items'], function (string $carry, object $item): string
                {
                    $carry .= $this->getRandomItem($item);
                    return $carry;
                }, "") . "
            
            <input type='submit' value='Recharger'></input>
            </form>
        ";
    }

    private function getRandomItem(object $item): string
    {
        return "
            <div>
                <input type='checkbox' ". (($item->active) ? "checked='checked'" : '') ." name='$item->title'><h2 style='display: inline'>$item->title</h2>
                <p>" . (is_array($item->result) ? implode(", ", $item->result) : $item->result) . "</p>
            </div>
        ";
    }

}