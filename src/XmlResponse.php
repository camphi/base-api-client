<?php

namespace Camphi\BaseApiClient;


class XmlResponse extends AbstractResponse
{
    /**
     * @param mixed $content
     * @return mixed
     */
    protected function decodeContents($contents)
    {
        return simplexml_load_string($contents);
    }

}