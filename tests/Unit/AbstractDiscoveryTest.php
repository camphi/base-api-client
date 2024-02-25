<?php
use Camphi\BaseApiClient\AbstractDiscovery;
use Camphi\BaseApiClient\AbstractResource;
use Camphi\BaseApiClient\ClientManager;
use Camphi\BaseApiClient\Tests\Unit\Assets\DemoAbstractDiscovery;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

uses()->beforeEach(function () {
    $this->mockClient = Mockery::mock(Client::class);
    $this->discoveryDemo = new DemoAbstractDiscovery($this->mockClient);
});

test('Discovery Create', function () {
    $config = [
            'base_uri' => 'https://httpbin.org/api/',
            'headers' => [
                'Authorization' => 'Bearer xxxx'
            ]
        ];
    $apiDemo = new class ($config) extends AbstractDiscovery {};
    expect($apiDemo)->toBeInstanceOf(AbstractDiscovery::class);
});

test('Discovery Dynamic Resources', function () {
    expect($this->discoveryDemo->resourcedemo)->toBeInstanceOf(AbstractResource::class);
});

test('Discovery Dynamic Resources isset', function () {
    expect(isset($this->discoveryDemo->resourcedemo))->toBeFalse();
    $this->discoveryDemo->resourcedemo;
    expect(isset($this->discoveryDemo->resourcedemo))->toBeTrue();
});

test('Discovery Dynamic Resource Invoke Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('get', 'http://httpbin.org/', ['query' => []])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
});

test('Discovery Defined Resources', function () {
    expect($this->discoveryDemo->resource())->toBeInstanceOf(AbstractResource::class);
});

test('Discovery Defined Resource Invoke Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('get', 'http://httpbin.org/', ['query' => []])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resource()('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
});

test('Discovery Invalid Resource Name', function () {
    $disc = new class () extends AbstractDiscovery {};
    expect($disc->error())->toBeNull();
});

test('Discovery Update Client Config', function () {
    expect($this->discoveryDemo->getClientDefaultConfig())->toBe([]);
    $this->discoveryDemo->updateDefaultConfig(['test' => 'bar']);
    expect($this->discoveryDemo->getClientDefaultConfig())->toBe(['test' => 'bar']);
    $this->discoveryDemo->updateDefaultConfig(['foo' => 'bar']);
    expect($this->discoveryDemo->getClientDefaultConfig())->toBe(['foo' => 'bar']);
    $this->discoveryDemo->updateDefaultConfig(['foobar' => 'barbar'], true);
    expect($this->discoveryDemo->getClientDefaultConfig())->toBe(['foo' => 'bar', 'foobar' => 'barbar']);
    $this->discoveryDemo->updateDefaultConfig(['foobar' => 'rabrab'], true);
    expect($this->discoveryDemo->getClientDefaultConfig())->toBe(['foo' => 'bar', 'foobar' => 'rabrab']);
});