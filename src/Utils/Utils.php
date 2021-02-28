<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Utils;

class Utils
{
    public static function round(int $amount): float
    {
        return round($amount / 100, 2);
    }
}