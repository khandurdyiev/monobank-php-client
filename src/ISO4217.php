<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient;

use Alcohol\ISO4217 as AlcoholISO4217;

class ISO4217
{
    public static function create(): ISO4217
    {
        return new self();
    }

    /**
     * @param int $code
     *
     * @return string
     */
    public function getByNumeric(int $code): string
    {
        $numeric = sprintf("%03d", $code);

        try {
            return (string) (new AlcoholISO4217())->getByNumeric($numeric)['alpha3'];
        } catch (\OutOfBoundsException $exception) {
            switch ($numeric) {
                case '894':
                    return 'ZMW';
                case '795':
                    return 'TMT';
                case '478':
                    return 'MNT';
                default:
                    throw new \OutOfBoundsException('ISO 4217 does not contain: ' . $code);
            }
        }
    }
}
