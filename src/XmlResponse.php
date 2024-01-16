<?php

namespace Camphi\BaseApiClient;

class XmlResponse extends AbstractResponse
{
    /**
     * @param mixed $contents
     * @return mixed
     */
    protected function decodeContents(mixed $contents): mixed
    {
        return simplexml_load_string($contents);
    }

}