<?php
use Camphi\BaseApiClient\ClientManager;
use Camphi\BaseApiClient\Tests\Feature\Assets\DemoClientManager;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;

uses()->beforeEach(function () {
    $this->mockClient = Mockery::mock(Client::class);
});

test('ClientManager Create', function () {
    $config = [
            'base_uri' => 'https://httpbin.org/api/',
            'headers' => [
                'Authorization' => 'Bearer xxxx'
            ]
        ];
    $clientManager = new ClientManager($config);
    expect($clientManager)->toBeInstanceOf(ClientManager::class);
});

test('ClientManager Update Client Config', function () {
    $config = [
            'base_uri' => 'https://httpbin.org/api/',
            'headers' => [
                'Authorization' => 'Bearer xxxx'
            ]
        ];
    $clientManager = new DemoClientManager($this->mockClient, $config);
    expect($clientManager->getClientDefaultConfig())->toBe($config);
    $clientManager->updateClientDefaultConfig(['test' => 'bar']);
    expect($clientManager->getClientDefaultConfig())->toBe(['test' => 'bar']);
    $clientManager->updateClientDefaultConfig(['foo' => 'bar']);
    expect($clientManager->getClientDefaultConfig())->toBe(['foo' => 'bar']);
    $clientManager->updateClientDefaultConfig(['foobar' => 'barbar'], true);
    expect($clientManager->getClientDefaultConfig())->toBe(['foo' => 'bar', 'foobar' => 'barbar']);
    $clientManager->updateClientDefaultConfig(['foobar' => 'rabrab'], true);
    expect($clientManager->getClientDefaultConfig())->toBe(['foo' => 'bar', 'foobar' => 'rabrab']);
});

test('ClientManager Passthrough ClientInterface', function () {
    $config = [
            'base_uri' => 'https://httpbin.org/api/',
            'headers' => [
                'Authorization' => 'Bearer xxxx'
            ]
        ];
    $clientManager = new DemoClientManager($this->mockClient, $config);

    $request = Mockery::mock(RequestInterface::class);
    $response = Mockery::mock(ResponseInterface::class);
    $promise = Mockery::mock(PromiseInterface::class);

    $this->mockClient
        ->shouldReceive('send')
        ->with($request, ['query' => []])
        ->andReturn($response)
        
        ->shouldReceive('sendAsync')
        ->with($request, ['query' => []])
        ->andReturn($promise)
        
        ->shouldReceive('request')
        ->with('get', 'http://httpbin.org/', ['query' => []])
        ->andReturn($response)
        
        ->shouldReceive('requestAsync')
        ->with('get', 'http://httpbin.org/', ['query' => []])
        ->andReturn($promise)
        
        ->shouldReceive('getConfig')
        ->with('options')
        ->andReturn(['options' => [1,2,3]])
    ;
    expect($clientManager->send($request, ['query' => []]))->toBeInstanceOf(ResponseInterface::class);
    expect($clientManager->sendAsync($request, ['query' => []]))->toBeInstanceOf(PromiseInterface::class);
    expect($clientManager->request('get', 'http://httpbin.org/', ['query' => []]))->toBeInstanceOf(ResponseInterface::class);
    expect($clientManager->requestAsync('get', 'http://httpbin.org/', ['query' => []]))->toBeInstanceOf(PromiseInterface::class);
    expect($clientManager->getConfig('options'))->toBe(['options' => [1,2,3]]);
});