<?php

use Camphi\BaseApiClient\AbstractResponse;
use Camphi\BaseApiClient\JsonResponse;
use Camphi\BaseApiClient\XmlResponse;
use GuzzleHttp\Psr7\Response;

test('Custom Data Contents', function () {
    $response = new Response(200, [], '{"aaa":[1,2,3],"bbb":{"first":1,"second":2}}', '1.1', 'OK');
    $customResponse = new class ($response) extends AbstractResponse {
        protected function decodeContents($contents)
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
