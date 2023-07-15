<?php

namespace Camphi\BaseApiClient\Tests\Feature\Assets;

use Camphi\BaseApiClient\AbstractDiscovery;
use Camphi\BaseApiClient\AbstractResource;


class DemoAbstractDiscovery extends AbstractDiscovery
{

    protected array $resources = [
        'resourcedemo' => DemoAbstractResource::class
    ];

    public function __construct(
        $mockClient,
        array $clientDefaultConfig = []
    ) {
        $clientManager = new DemoClientManager($mockClient, $clientDefaultConfig);
        $this->clientManager = $clientManager;
    }

    protected AbstractResource $resource;
    public function resource(): AbstractResource
    {
        if (empty($this->resource)) {
            $this->resource = new DemoAbstractResource($this->clientManager);
        }
        return $this->resource;
    }
}