<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\Statement;

use JsonSerializable;
use Khandurdyiev\MonoClient\ISO4217;

class Statement implements JsonSerializable
{
    private string $id;
    private int $time;
    private string $description;
    private int $mcc;
    private bool $hold;
    private int $amount;
    private int $operationAmount;
    private int $currencyCode;
    private int $commissionRate;
    private int $cashbackAmount;
    private int $balance;
    private string $comment;
    private string $receiptId;
    private string $counterEdrpou;
    private string $counterIban;

    /**
     * @param array<string, mixed> $statement
     */
    public function __construct(array $statement)
    {
        $this->id = (string) $statement['id'];
        $this->time = (int) $statement['time'];
        $this->description = (string) $statement['description'];
        $this->mcc = (int) $statement['mcc'];
        $this->hold = (bool) $statement['hold'];
        $this->amount = (int) $statement['amount'];
        $this->operationAmount = (int) $statement['operationAmount'];
        $this->currencyCode = (int) $statement['currencyCode'];
        $this->commissionRate = (int) $statement['commissionRate'];
        $this->cashbackAmount = (int) $statement['cashbackAmount'];
        $this->balance = (int) $statement['balance'];
        $this->comment = $statement['comment'] ?? '';
        $this->receiptId = $statement['receiptId'] ?? '';
        $this->counterEdrpou = $statement['counterEdrpou'] ?? '';
        $this->counterIban = $statement['counterIban'] ?? '';
    }

    /**
     * @param array<string, mixed> $statement
     *
     * @return Statement
     */
    public static function create(array $statement): Statement
    {
        return new self($statement);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMcc(): int
    {
        return $this->mcc;
    }

    public function isHold(): bool
    {
        return $this->hold;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getOperationAmount(): int
    {
        return $this->operationAmount;
    }

    public function getCurrencyCode(): int
    {
        return $this->currencyCode;
    }

    public function getCurrency(): string
    {
        return ISO4217::create()->getByNumeric($this->currencyCode);
    }

    public function getCommissionRate(): int
    {
        return $this->commissionRate;
    }

    public function getCashbackAmount(): int
    {
        return $this->cashbackAmount;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getReceiptId(): string
    {
        return $this->receiptId;
    }

    public function getCounterEdrpou(): string
    {
        return $this->counterEdrpou;
    }

    public function getCounterIban(): string
    {
        return $this->counterIban;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'time' => $this->getTime(),
            'description' => $this->getDescription(),
            'mcc' => $this->getMcc(),
            'hold' => $this->isHold(),
            'amount' => $this->getAmount(),
            'operation_amount' => $this->getOperationAmount(),
            'currency_code' => $this->getCurrencyCode(),
            'commission_rate' => $this->getCommissionRate(),
            'cashback_amount' => $this->getCashbackAmount(),
            'balance' => $this->getBalance(),
            'comment' => $this->getComment(),
            'receipt_id' => $this->getReceiptId(),
            'counter_edrpou' => $this->getCounterEdrpou(),
            'counter_iban' => $this->getCounterIban(),
        ];
    }
}
