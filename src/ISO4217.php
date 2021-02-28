<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient;

use Alcohol\ISO4217 as AlcoholISO4217;

class ISO4217
{
    private AlcoholISO4217 $iso4217;

    public function __construct(AlcoholISO4217 $iso4217)
    {
        $this->iso4217 = $iso4217;
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
            /** @var string $code */
            $code = $this->iso4217->getByNumeric($numeric)['alpha3'];

            return $code;
        } catch (\OutOfBoundsException $exception) {
            switch ($numeric) {
                case '894':
                    return 'ZMW';
                case '795':
                    return 'TMT';
                case '478':
                    return 'MNT';
            }
        }

        throw new \OutOfBoundsException('ISO 4217 does not contain: ' . $code);
    }
}
