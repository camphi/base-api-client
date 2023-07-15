<?php

use Camphi\BaseApiClient\Tests\Feature\Assets\DemoAbstractDiscovery;
use Camphi\BaseApiClient\AbstractDiscovery;
use Camphi\BaseApiClient\AbstractResource;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

uses()->beforeEach(function () {
    $this->mockClient = Mockery::mock(Client::class);
    $this->discoveryDemo = new DemoAbstractDiscovery($this->mockClient);
});

test('Resource Create', function () {
    $apiResourceDemo = new class ($this->mockClient) extends AbstractResource {};
    expect($apiResourceDemo)->toBeInstanceOf(AbstractResource::class);
});

test('Resource Get Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('get', 'http://httpbin.org/', ['query' => []])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo->get('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
    expect($this->discoveryDemo->resource()->get('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
});

test('Resource Post Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('post', 'http://httpbin.org/', ['body' => 'post body'])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo->post('http://httpbin.org/', 'post body'))->toBeInstanceOf(ResponseInterface::class);
    expect($this->discoveryDemo->resource()->post('http://httpbin.org/', 'post body'))->toBeInstanceOf(ResponseInterface::class);
});

test('Resource Put Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('put', 'http://httpbin.org/', ['body' => 'put body'])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo->put('http://httpbin.org/', 'put body'))->toBeInstanceOf(ResponseInterface::class);
    expect($this->discoveryDemo->resource()->put('http://httpbin.org/', 'put body'))->toBeInstanceOf(ResponseInterface::class);
});

test('Resource Delete Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('delete', 'http://httpbin.org/', [])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo->delete('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
    expect($this->discoveryDemo->resource()->delete('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
});

test('Resource Head Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('head', 'http://httpbin.org/', [])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo->head('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
    expect($this->discoveryDemo->resource()->head('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
});

test('Resource Options Method', function () {
    $this->mockClient
        ->shouldReceive('request')
        ->with('options', 'http://httpbin.org/', [])
        ->andReturn(Mockery::mock(ResponseInterface::class))
    ;
    expect($this->discoveryDemo->resourcedemo->options('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
    expect($this->discoveryDemo->resource()->options('http://httpbin.org/'))->toBeInstanceOf(ResponseInterface::class);
});