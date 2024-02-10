<?php

namespace Camphi\BaseApiClient;

class JsonResponse extends AbstractResponse
{
    /**
     * @param mixed $contents
     * @return mixed
     * @throws \JsonException
     */
    protected function decodeContents(mixed $contents): mixed
    {
        return json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
    }
}