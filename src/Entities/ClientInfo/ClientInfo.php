<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\ClientInfo;

use JsonSerializable;

class ClientInfo implements JsonSerializable
{
    private string $id;
    private string $name;
    private string $webHookUrl;
    private string $permissions;
    private AccountCollection $accounts;

    /**
     * @param array<string, mixed> $clientInfo
     */
    public function __construct(array $clientInfo)
    {
        $this->id = (string) $clientInfo['clientId'];
        $this->name = (string) $clientInfo['name'];
        $this->webHookUrl = (string) $clientInfo['webHookUrl'];
        $this->permissions = (string) $clientInfo['permissions'];
        $this->accounts = $this->getAccountCollection($clientInfo);
    }

    /**
     * @param array<string, mixed> $clientInfo
     *
     * @return ClientInfo
     */
    public static function create(array $clientInfo): ClientInfo
    {
        return new self($clientInfo);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getWebHookUrl(): string
    {
        return $this->webHookUrl;
    }

    public function getAccounts(): AccountCollection
    {
        return $this->accounts;
    }

    public function getPermissions(): string
    {
        return $this->permissions;
    }

    /**
     * @param array<string, mixed> $clientInfo
     *
     * @return AccountCollection
     */
    private function getAccountCollection(array $clientInfo): AccountCollection
    {
        /** @var array<int, array<string, mixed>> $accounts */
        $accounts = $clientInfo['accounts'];

        return AccountCollection::create($accounts);
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'webhook_url' => $this->getWebHookUrl(),
            'permissions' => $this->getPermissions(),
            'accounts' => $this->getAccounts()
        ];
    }
}
