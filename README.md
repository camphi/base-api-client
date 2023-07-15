# Camphi Base Api Client
Abstract the base needs of an api client and help with documentation.

## Installation
Update the composer.json repositories with :
Then you can add the module to the project : `composer require camphi/base-api-client`

## Usage
Create a discovery and some resources included in the discovery for a clearer documentation.
Ex:


Discovery.php
```php
<?php
namespace Camphi\Examples;

use Camphi\Examples\Resource;
use Camphi\BaseApiClient\AbstractDiscovery;

/**
 * @property Resource $resource Resource description
 */
class Discovery extends AbstractDiscovery
{
    protected array $resources = [
        'resource' => Resource::class
    ];
}
```

Resource.php
```php
<?php
namespace Camphi\Examples;

use Camphi\BaseApiClient\AbstractResponse;
use Camphi\BaseApiClient\JsonResponse;
use Camphi\BaseApiClient\XmlResponse;
use Camphi\BaseApiClient\AbstractResource;

class Resource extends AbstractResource
{
    public function getEndpoint(array $params = [], array $options = [])
    {
        $method = 'get';
        $uri = 'resource/endpoint';
        $options = array_merge($options, [
            'query' => $params
        ]);
        return new JsonResponse($this->request($method, $uri, $options));
    }

    public function getEndpointById($id, array $options = [])
    {
        $method = 'get';
        $uri = 'resource/endpoint/' . $id;
        return new XmlResponse($this->request($method, $uri, $options));
    }

    public function postToResource($body, array $options = [])
    {
        $method = 'post';
        $uri = 'resource/endpoint/';
        $options = array_merge($options, [
            'body' => $body
        ]);
        return new class ($this->request($method, $uri, $options)) extends AbstractResponse {
            protected function decodeContents($contents)
            {
                return json_decode($contents, true);
            }
        };
    }

    public function putToResource($id, $body, array $options = [])
    {
        $method = 'put';
        $uri = 'resource/endpoint/' . $id;
        $options = array_merge($options, [
            'body' => $body
        ]);
        return $this->request($method, $uri, $options);
    }
}
```

Main.php
```php
<?php
namespace Camphi\Examples;

use Camphi\Examples\Discovery;

class Main
{
    protected Discovery $api;
    
    public function process()
    {
        $config = [
            'base_uri' => 'https://foo.com/api/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getBearerToken()
            ]
        ];
        $this->api = new Discovery($config);
        
        // use a documented endpoint
        $jsonResponseObject = $this->api->resource->getEndpoint(['parent_id' => 1]);
        
        // use an undocumented endpoint
        // get https://foo.com/api/v2/custom-one/2
        $response = $this->api->resource->get('v2/custom-one/2');
        
    }
}
```

## Contribute
We use semver:
```text
Given a version number MAJOR.MINOR.PATCH, increment the:

    MAJOR version when you make incompatible API changes,
    MINOR version when you add functionality in a backwards compatible manner, and
    PATCH version when you make backwards compatible bug fixes.

Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.
```
Do not add the version number to the composer.json.

## Package
``v="x.y.z" && git checkout v"$v" && jq -M --arg v "$v" '. +={version: $v}' composer.json > c_v.j && mv -- c_v.j composer.json && zip -rq lib-baseapiclient_v${v}.zip composer.json README.md src/ && git checkout . && git checkout -``
