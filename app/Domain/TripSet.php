<?php

namespace App\Domain;

class TripSet
{
    public int $x;
    public int $y;

    function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}
