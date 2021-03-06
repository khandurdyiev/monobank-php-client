<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use GuzzleHttp\Utils;
use Khandurdyiev\MonoClient\Entities\ClientInfo\ClientInfo;
use Khandurdyiev\MonoClient\Entities\Currency\CurrencyCollection;
use Khandurdyiev\MonoClient\Entities\Statement\StatementCollection;
use Khandurdyiev\MonoClient\Exceptions\InvalidDateForStatementException;
use Khandurdyiev\MonoClient\Exceptions\MonobankApiException;

class MonoClient
{
    private Client $client;

    /**
     * @param string $token
     *
     * @param array<string, mixed> $customConfig
     */
    public function __construct(string $token = '', array $customConfig = [])
    {
        $this->client = Client::create(
            array_merge(['headers' => ['X-Token' => $token]], $customConfig)
        );
    }

    /**
     * @param string $token
     * @param array<string, mixed> $customConfig
     *
     * @return MonoClient
     */
    public static function create(string $token, array $customConfig = []): MonoClient
    {
        return new self($token, $customConfig);
    }

    /**
     * @return ClientInfo
     *
     * @throws Exceptions\MonobankApiException
     */
    public function clientInfo(): ClientInfo
    {
        $response = $this->client->get('personal/client-info');

        /** @var array<string, mixed> $decoded */
        $decoded = Utils::jsonDecode($response->getBody()->getContents(), true);

        return new ClientInfo($decoded);
    }

    /**
     * @param string $url
     *
     * @return bool
     * @throws Exceptions\MonobankApiException
     */
    public function webhook(string $url): bool
    {
        $response = $this->client->post('personal/webhook', [
            'body' => ['webHookUrl' => $url]
        ]);

        return $response->getStatusCode() === 200;
    }

    /**
     * @param Carbon $from
     * @param Carbon|null $to
     * @param string $accountId
     *
     * @return StatementCollection
     *
     * @throws InvalidDateForStatementException
     * @throws MonobankApiException
     */
    public function statements(Carbon $from, ?Carbon $to = null, string $accountId = '0'): StatementCollection
    {
        $fromTimestamp = $from->getTimestamp();

        if ($to === null) {
            $toTimestamp = 0;
        } else {
            $toTimestamp = $to->getTimestamp();
        }

        $diffSeconds = $toTimestamp - $fromTimestamp;

        if (CarbonInterval::seconds($diffSeconds)->greaterThan(CarbonInterval::days(31)->addHours(1))) {
            throw new InvalidDateForStatementException('The maximum time limit exceeded for getting statement.');
        }

        $url = "personal/statement/$accountId/$fromTimestamp";

        if ($toTimestamp > 0) {
            $url .= "/$toTimestamp";
        }

        $response = $this->client->get($url);

        /** @var array<int, array<string, mixed>> $decoded */
        $decoded = Utils::jsonDecode($response->getBody()->getContents(), true);

        return new StatementCollection($decoded);
    }

    /**
     * @return CurrencyCollection
     *
     * @throws Exceptions\MonobankApiException
     */
    public function currency(): CurrencyCollection
    {
        $response = $this->client->get('bank/currency');

        /** @var array<int, array<string, mixed>> $decoded */
        $decoded = Utils::jsonDecode($response->getBody()->getContents(), true);

        return CurrencyCollection::create($decoded);
    }
}
