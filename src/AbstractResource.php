<?php

namespace Camphi\BaseApiClient;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractResource
{
    protected ClientInterface $client;
    // protected array $updatedDefaultOptions = [];

    public function __construct(
        ClientInterface $client
    ) {
        $this->client = $client;
    }

    // public function getClient(): ClientInterface
    // {
    //     $this->client;
    // }

    // public function setClient(ClientInterface $client)
    // {
    //     $this->client = $client;
    // }

    protected function request(string $method, string $uri, array $options): ResponseInterface
    {
        // general resource validation
        // ...
        return $this->client->request($method, $uri, $options);
    }

    public function get(string $uri, array $params = [], array $options = []): ResponseInterface
    {
        $method = 'get';
        $options = array_merge($options, [
            'query' => $params
        ]);
        return $this->request($method, $uri, $options);
    }

    public function post(string $uri, $body, array $options = []): ResponseInterface
    {
        $method = 'post';
        $options = array_merge($options, [
            'body' => $body
        ]);
        return $this->request($method, $uri, $options);
    }

    public function put(string $uri, $body, array $options = []): ResponseInterface
    {
        $method = 'put';
        $options = array_merge($options, [
            'body' => $body
        ]);
        return $this->request($method, $uri, $options);
    }

    public function delete(string $uri, array $options = []): ResponseInterface
    {
        $method = 'delete';
        return $this->request($method, $uri, $options);
    }

    public function head(string $uri, array $options = []): ResponseInterface
    {
        $method = 'head';
        return $this->request($method, $uri, $options);
    }

    public function options(string $uri, array $options = []): ResponseInterface
    {
        $method = 'options';
        return $this->request($method, $uri, $options);
    }
}