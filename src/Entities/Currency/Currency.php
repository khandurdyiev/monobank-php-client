<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\Currency;

use Alcohol\ISO4217 as AlcoholISO4217;
use Khandurdyiev\MonoClient\ISO4217;
use Carbon\Carbon;

class Currency implements \JsonSerializable
{
    private int $currencyCodeA;
    private int $currencyCodeB;
    private int $timestamp;
    private ?float $rateSell;
    private ?float $rateBuy;
    private ?float $rateCross;
    private ISO4217 $iso4217;

    /**
     * @param array<string, mixed> $currency
     */
    public function __construct(array $currency)
    {
        $this->currencyCodeA = (int) $currency['currencyCodeA'];
        $this->currencyCodeB = (int) $currency['currencyCodeB'];
        $this->timestamp = (int) $currency['date'];
        $this->rateSell = isset($currency['rateSell']) ? (float) $currency['rateSell'] : null;
        $this->rateBuy = isset($currency['rateBuy']) ? (float) $currency['rateBuy'] : null;
        $this->rateCross = isset($currency['rateCross']) ? (float) $currency['rateCross'] : null;
        $this->iso4217 = new ISO4217(new AlcoholISO4217());
    }

    /**
     * @param array<string, mixed> $currency
     *
     * @return Currency
     */
    public static function create(array $currency): Currency
    {
        return new self($currency);
    }

    public function getCurrencyCodeA(): int
    {
        return $this->currencyCodeA;
    }

    public function getCurrencyCodeB(): int
    {
        return $this->currencyCodeB;
    }

    public function getCurrencyA(): string
    {
        return $this->iso4217->getByNumeric($this->currencyCodeA);
    }

    public function getCurrencyB(): string
    {
        return $this->iso4217->getByNumeric($this->currencyCodeB);
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getDate(): Carbon
    {
        return Carbon::createFromTimestamp($this->timestamp);
    }

    public function getRateSell(): ?float
    {
        return $this->rateSell;
    }

    public function getRateBuy(): ?float
    {
        return $this->rateBuy;
    }

    public function getRateCross(): ?float
    {
        return $this->rateCross;
    }

    public function jsonSerialize()
    {
        return [
            'currency_code_a' => $this->getCurrencyCodeA(),
            'currency_a' => $this->getCurrencyA(),
            'currency_code_b' => $this->getCurrencyCodeB(),
            'currency_b' => $this->getCurrencyB(),
            'timestamp' => $this->getTimestamp(),
            'rate_sell' => $this->getRateSell(),
            'rate_buy' => $this->getRateBuy(),
            'rate_cross' => $this->getRateCross(),
        ];
    }
}
