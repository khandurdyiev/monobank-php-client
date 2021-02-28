<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Message;
use Khandurdyiev\MonoClient\Exceptions\MonobankApiException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Client
{
    private const URL = 'https://api.monobank.ua';

    private GuzzleClient $client;

    /**
     * @param array<string, mixed> $customConfig
     */
    public function __construct(array $customConfig)
    {
        $config = array_merge(['base_uri' => self::URL], $customConfig);

        $this->client = new GuzzleClient($config);
    }

    /**
     * @param array<string, mixed> $customConfig
     *
     * @return Client
     */
    public static function create(array $customConfig = []): Client
    {
        return new self($customConfig);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('GET', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function head(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('HEAD', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function put(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('PUT', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('POST', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function patch(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('PATCH', $uri, $options);
    }

    /**
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function delete(string $uri, array $options = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, $options);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return ResponseInterface
     *
     * @throws MonobankApiException
     */
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (Throwable $exception) {
            $message = $exception->getMessage();

            if ($exception instanceof RequestException && $exception->hasResponse()) {
                /** @var ResponseInterface $response */
                $response = $exception->getResponse();

                $message = Message::toString($response);
            }

            throw new MonobankApiException($message, (int) $exception->getCode(), $exception);
        }

        return $response;
    }
}
