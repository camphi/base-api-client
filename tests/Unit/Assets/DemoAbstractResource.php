<?php

namespace Camphi\BaseApiClient\Tests\Unit\Assets;

use Camphi\BaseApiClient\AbstractResource;

class DemoAbstractResource extends AbstractResource
{
    public function __invoke(string $uri, array $params = [], array $options = [])
    {
        return $this->get($uri, $params, $options);
    }
}