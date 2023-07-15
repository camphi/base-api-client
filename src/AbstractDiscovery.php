<?php

namespace Camphi\BaseApiClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

abstract class AbstractDiscovery
{
    protected ClientInterface $clientManager;

    protected array $resources = [];

    /**
     * Instances of $this->resources classes
     *
     * @var [\Camphi\BaseApiClient\AbstractResource]
     */
    protected array $instanceOfResources = [];

    public function __construct(
        array $clientDefaultConfig = []
    ) {
        $clientManager = new ClientManager($clientDefaultConfig);
        
        $this->clientManager = $clientManager;
    }

    public function updateDefaultConfig(array $defaultConfig = [], bool $merge = false)
    {
        $this->clientManager->updateClientDefaultConfig($defaultConfig, $merge);
    }

    public function getClientDefaultConfig(): array
    {
        return $this->clientManager->getClientDefaultConfig();
    }

    public function __get($name)
    {
        if (isset($this->resources[$name])) {
            if (empty($this->instanceOfResources[$name])) {
                $this->instanceOfResources[$name] = new $this->resources[$name]($this->clientManager);
            }
            return $this->instanceOfResources[$name];
        }
    }
    
    public function __isset($name)
    {
        return isset($this->instanceOfResources[$name]);
    }

    public function __call($name, $args)
    {
        if (is_callable($this->__get($name))) {
            return $this->__get($name)(...$args);
        }
    }

}