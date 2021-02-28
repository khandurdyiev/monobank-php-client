<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\Currency;

class CurrencyCollection implements \JsonSerializable
{
    /** @var Currency[] */
    private array $collection = [];

    /**
     * @param array<int, array<string, mixed>> $currencies
     */
    public function __construct(array $currencies)
    {
        foreach ($currencies as $currency) {
            $this->collection[] = Currency::create($currency);
        }
    }

    /**
     * @param array<int, array<string, mixed>> $currencies
     *
     * @return CurrencyCollection
     */
    public static function create(array $currencies): CurrencyCollection
    {
        return new self($currencies);
    }

    /**
     * @return Currency[]
     */
    public function all(): array
    {
        return $this->collection;
    }

    public function jsonSerialize()
    {
        return $this->all();
    }
}
