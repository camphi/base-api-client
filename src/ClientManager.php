<?php

namespace Camphi\BaseApiClient;

use ReflectionClass;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ClientManager implements ClientInterface
{
    protected array $clientDefaultConfig = [];
    protected ClientInterface $client;
    protected ReflectionClass $reflected;

    public function __construct(
        array $clientDefaultConfig = []
    ) {
        $this->updateClientDefaultConfig($clientDefaultConfig);
    }

    public function updateClientDefaultConfig(array $clientDefaultConfig, bool $merge = false)
    {
        if ($merge) {
            $clientDefaultConfig = array_merge($this->clientDefaultConfig, $clientDefaultConfig);
        }

        $this->clientDefaultConfig = $clientDefaultConfig;
        $client = new Client($clientDefaultConfig);
        
        $this->client = $client;
        $this->reflected = new ReflectionClass($client);
    }

    public function getClientDefaultConfig(): array
    {
        return $this->clientDefaultConfig;
    }
    
    /**
     * Send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array            $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @throws GuzzleException
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->client->send($request, $options);
    }

    /**
     * Asynchronously send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array            $options Request options to apply to the given
     *                                  request and to the transfer.
     */
    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->client->sendAsync($request, $options);
    }

    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string              $method  HTTP method.
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply.
     *
     * @throws GuzzleException
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }

    /**
     * Create and send an asynchronous HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well. Use an array to provide a URL
     * template and additional variables to use in the URL template expansion.
     *
     * @param string              $method  HTTP method
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply.
     */
    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        return $this->client->requestAsync($method, $uri, $options);
    }

    /**
     * Get a client configuration option.
     *
     * These options include default request options of the client, a "handler"
     * (if utilized by the concrete client), and a "base_uri" if utilized by
     * the concrete client.
     *
     * @param string|null $option The config option to retrieve.
     *
     * @return mixed
     *
     * @deprecated ClientInterface::getConfig will be removed in guzzlehttp/guzzle:8.0.
     */
    public function getConfig(?string $option = null)
    {
        return $this->client->getConfig($option);
    }
    
    public function __get(string $name): mixed
    {
        $property = $this->reflected->getProperty($name);
        return $property->getValue($this->obj);
    }

    public function __set(string $name, mixed $value): void
    {
        $property = $this->reflected->getProperty($name);
        $property->setValue($this->obj, $value);
    }

    public function __call(string $name, array $params = []): mixed
    {
        $method = $this->reflected->getMethod($name);
        return $method->invoke($this->obj, ...$params);
    }

}