<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\ClientInfo;

use Alcohol\ISO4217 as AlcoholISO4217;
use Khandurdyiev\MonoClient\ISO4217;
use Khandurdyiev\MonoClient\Utils\Utils;

class Account implements \JsonSerializable
{
    private string $id;
    private int $balance;
    private int $creditLimit;
    private string $type;
    private int $currencyCode;
    private string $cashbackType;
    private string $iban;
    /**
     * @var array<int, string>
     */
    private array $maskedPan;
    private ISO4217 $iso4217;

    /**
     * @param array<string, mixed> $account
     */
    public function __construct(array $account)
    {
        $this->id = (string)$account['id'];
        $this->currencyCode = (int)$account['currencyCode'];
        $this->cashbackType = (string)$account['cashbackType'];
        $this->balance = (int)$account['balance'];
        $this->creditLimit = (int)$account['creditLimit'];
        $this->type = (string)$account['type'];
        $this->iban = (string)$account['iban'];
        $this->maskedPan = (array)$account['maskedPan'];
        $this->iso4217 = new ISO4217(new AlcoholISO4217());
    }

    /**
     * @param array<string, mixed> $account
     *
     * @return Account
     */
    public static function create(array $account): Account
    {
        return new self($account);
    }

    public function getBalance(): float
    {
        return Utils::round($this->balance);
    }

    public function getCreditLimit(): float
    {
        return Utils::round($this->balance);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCurrencyCode(): int
    {
        return $this->currencyCode;
    }

    public function getCurrency(): string
    {
        return $this->iso4217->getByNumeric($this->currencyCode);
    }

    public function getCashbackType(): string
    {
        return $this->cashbackType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<int, string>
     */
    public function getMaskedPan(): array
    {
        return $this->maskedPan;
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'currency_code' => $this->getCurrencyCode(),
            'currency' => $this->getCurrency(),
            'cashback_type' => $this->getCashbackType(),
            'balance' => $this->getBalance(),
            'credit_limit' => $this->getCreditLimit(),
            'type' => $this->getType(),
            'iban' => $this->getIban(),
            'masked_pan' => $this->getMaskedPan(),
        ];
    }
}
