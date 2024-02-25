<?php

namespace Camphi\BaseApiClient;

abstract class AbstractDataModel
{

    public function __construct(
        protected array $_data = []
    )
    {
    }

    public function getData(string $name = '', $default = null): mixed
    {
        if ('' === $name) {
            return $this->_data;
        }

        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        
        return $default;
    }

    public function setData(string $name, mixed $value): void
    {
        $this->_data[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        return $this->getData($name);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->setData($name, $value);
    }

    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }
    
    public function isEmpty(): bool
    {
        return empty($this->_data);
    }
}