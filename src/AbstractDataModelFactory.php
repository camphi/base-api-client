<?php

namespace Camphi\BaseApiClient;

abstract class AbstractDataModelFactory
{
    public static function create(array $data = []): AbstractDataModel
    {
        return new class ($data) extends AbstractDataModel {};
    }
}