<?php

use Camphi\BaseApiClient\AbstractDataModel;

test('Can be Empty', function () {
    $dataModel = new class () extends AbstractDataModel {};
    expect($dataModel)->toBeInstanceOf(AbstractDataModel::class);
    expect($dataModel->isEmpty())->toBe(true);
});

test('Can Create DataModel', function () {
    $dataModel = new class (['a' => 'b', 'b' => 'c']) extends AbstractDataModel {};
    expect($dataModel)->toBeInstanceOf(AbstractDataModel::class);
    expect($dataModel->isEmpty())->toBe(false);
    expect($dataModel->getData())->toBe(['a' => 'b', 'b' => 'c']);
});

test('Can Get Data', function () {
    $dataModel = new class (['a' => 'b', 'b' => 'c']) extends AbstractDataModel {};
    expect($dataModel->a)->toBe('b');
    expect($dataModel->getData('a'))->toBe('b');
    expect($dataModel->getData())->toBe(['a' => 'b', 'b' => 'c']);
});

test('Can Set Data', function () {
    $dataModel = new class (['a' => 'b', 'b' => 'c']) extends AbstractDataModel {};
    expect($dataModel)->toBeInstanceOf(AbstractDataModel::class);
    expect($dataModel->isEmpty())->toBe(false);
    expect($dataModel->a)->toBe('b');
    expect($dataModel->getData('a'))->toBe('b');
    $dataModel->setData('d', 'e');
    $dataModel->f = 'g';
    $dataModel->b = 'h';
    expect($dataModel->getData())->toBe(['a' => 'b', 'b' => 'h', 'd' => 'e', 'f' => 'g']);
});
