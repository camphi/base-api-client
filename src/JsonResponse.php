<?php

namespace Camphi\BaseApiClient;

class JsonResponse extends AbstractResponse
{
    /**
     * @param mixed $content
     * @return mixed
     */
    protected function decodeContents($contents)
    {
        return json_decode($contents, true);
    }
}