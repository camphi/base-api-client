<?php

use Camphi\BaseApiClient\AbstractDataModel;
use Camphi\BaseApiClient\AbstractDataModelFactory;

test('Can Create DataModel', function () {
    $dataModel = AbstractDataModelFactory::create(['a' => 'b', 'b' => 'c']);
    expect($dataModel)->toBeInstanceOf(AbstractDataModel::class);

    $dataModel = AbstractDataModelFactory::create();
    expect($dataModel)->toBeInstanceOf(AbstractDataModel::class);
});
