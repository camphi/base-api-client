<?php

namespace Camphi\BaseApiClient\Tests\Feature\Assets;

use Exception;
use ReflectionClass;
use Camphi\BaseApiClient\ClientManager;
use GuzzleHttp\Client;

class DemoClientManager extends ClientManager
{
    protected $mockClient;
    
    public function __construct(
        $mockClient,
        array $clientDefaultConfig = []
    ) {
        $this->mockClient = $mockClient;
        $this->updateClientDefaultConfig($clientDefaultConfig);
    }

    public function updateClientDefaultConfig(array $clientDefaultConfig, bool $merge = false)
    {
        if ($merge) {
            $clientDefaultConfig = array_merge($this->clientDefaultConfig, $clientDefaultConfig);
        }
        
        $this->clientDefaultConfig = $clientDefaultConfig;
        $client = $this->mockClient;
        
        $this->client = $client;
        $this->reflected = new ReflectionClass(Client::class);
    }

}