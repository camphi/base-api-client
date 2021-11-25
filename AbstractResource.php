<?php

namespace Camphi\SimpleApiClient\Model;

use \GuzzleHttp\ClientInterface;

abstract class AbstractResource
{
    protected ClientInterface $client;
    public function __construct(
        ClientInterface $client
    )
    {
        $this->client = $client;
    }

    public function get(string $uri, array $params = [], array $options = [])
    {
        $method = 'get';
        $options = array_merge($options, [
            'query' => $params
        ]);
        return $this->client->request($method, $uri, $options);
    }

    public function post(string $uri, $body, array $options = [])
    {
        $method = 'post';
        $options = array_merge($options, [
            'body' => $body
        ]);
        return $this->client->request($method, $uri, $options);
    }

    public function put(string $uri, $body, array $options = [])
    {
        $method = 'put';
        $options = array_merge($options, [
            'body' => $body
        ]);
        return $this->client->request($method, $uri, $options);
    }

    public function delete(string $uri, array $options = [])
    {
        $method = 'delete';
        return $this->client->request($method, $uri, $options);
    }

    public function head(string $uri, array $options = [])
    {
        $method = 'head';
        return $this->client->request($method, $uri, $options);
    }

    public function options(string $uri, array $options = [])
    {
        $method = 'options';
        return $this->client->request($method, $uri, $options);
    }
}