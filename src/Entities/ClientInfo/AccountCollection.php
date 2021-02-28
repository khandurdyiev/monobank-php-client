<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\ClientInfo;

class AccountCollection implements \JsonSerializable
{
    /**
     * @var Account[]
     */
    private array $collection = [];

    /**
     * @param array<int, array<string, mixed>> $accounts
     */
    public function __construct(array $accounts)
    {
        foreach ($accounts as $account) {
            $this->collection[] = Account::create($account);
        }
    }

    /**
     * @param array<int, array<string, mixed>> $accounts
     *
     * @return AccountCollection
     */
    public static function create(array $accounts): AccountCollection
    {
        return new self($accounts);
    }

    /**
     * @return Account[]
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
