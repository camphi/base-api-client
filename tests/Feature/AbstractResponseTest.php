<?php

use Camphi\BaseApiClient\AbstractResponse;
use Camphi\BaseApiClient\JsonResponse;
use Camphi\BaseApiClient\Tests\Feature\Assets\DummyModel;
use Camphi\BaseApiClient\XmlResponse;
use GuzzleHttp\Psr7\Response;

test('Custom Data Contents', function () {
    $response = new Response(200, [], '{"aaa":[1,2,3],"bbb":{"first":1,"second":2}}', '1.1', 'OK');
    $customResponse = new class ($response) extends AbstractResponse {
        protected function decodeContents($contents): mixed
        {
            return json_decode($contents);
        }
    };
    expect($customResponse->getData()->bbb->second)->toBe(2);
});

test('Json Data Contents', function () {
    $response = new Response(200, [], '{"aaa":[1,2,3],"bbb":{"first":1,"second":2}}', '1.1', 'OK');
    $jsonResponse = new JsonResponse ($response);
    expect($jsonResponse->getData())->toBe(["aaa" => [1, 2, 3], "bbb" => ["first" => 1, "second" => 2]]);
});

test('XML Data Contents', function () {
    $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?><source><aaa>1</aaa><bbb><first>1</first><second>2</second></bbb></source>', '1.1', 'OK');
    $xmlResponse = new XmlResponse($response);
    expect($xmlResponse->getData())->toBeInstanceOf(SimpleXMLElement::class);
});

test('Json Data inflate', function () {
    $response = new Response(200, [], '{"aaa":[1,2,3],"bbb":{"first":1,"second":2}}', '1.1', 'OK');
    $jsonResponse = new JsonResponse ($response);
    expect($jsonResponse->inflate(DummyModel::class))->toBeInstanceOf(DummyModel::class)->toHaveProperty('aaa', [1,2,3]);
});

test('Xml Data inflate', function () {
    $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?><source><aaa>1</aaa><bbb><first>1</first><second>2</second></bbb></source>', '1.1', 'OK');
    $xmlResponse = new XmlResponse($response);
    expect($xmlResponse->inflate(DummyModel::class))->toBeInstanceOf(DummyModel::class)->toHaveProperty('aaa', [1]);
});

test('Json Data uinflate', function () {
    $response = new Response(200, [], '{"aaa":[1,2,3],"bbb":{"first":1,"second":2}}', '1.1', 'OK');
    $jsonResponse = new JsonResponse ($response);
    expect($jsonResponse->uinflate(function (mixed $data) {
        $dummy = new DummyModel();
        $dummy->aaa = $data['aaa'];
        return $dummy;
    }))->toBeInstanceOf(DummyModel::class)->toHaveProperty('aaa', [1, 2, 3]);
});

test('Xml Data uinflate', function () {
    $response = new Response(200, [], '<?xml version="1.0" encoding="UTF-8"?><source><aaa>1</aaa><bbb><first>1</first><second>2</second></bbb></source>', '1.1', 'OK');
    $xmlResponse = new XmlResponse($response);
    expect($xmlResponse->uinflate(function (mixed $data) {
        $dummy = new DummyModel();
        $dummy->aaa = (array) $data->aaa;
        return $dummy;
    }))->toBeInstanceOf(DummyModel::class)->toHaveProperty('aaa', [1]);
});