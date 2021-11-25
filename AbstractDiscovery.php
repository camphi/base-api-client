<?php

namespace Camphi\SimpleApiClient\Model;

use \GuzzleHttp\ClientInterface;
use \GuzzleHttp\Client;

abstract class AbstractDiscovery
{
    protected array $clientDefaultConfig;
    protected ClientInterface $client;
    
    public function __construct(
        array $clientDefaultConfig = [],
        string $clientClass = Client::class
    )
    {
        if (false === is_subclass_of($clientClass, ClientInterface::class)) {
            throw new \Exception($clientClass . ' is not a subclass of ' . ClientInterface::class);
        }
        $this->clientDefaultConfig = $clientDefaultConfig;
        $this->client = new $clientClass($clientDefaultConfig);
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
        return $this;
    }

    public function getClientDefaultConfig(): array
    {
        return $this->clientDefaultConfig;
    }

}