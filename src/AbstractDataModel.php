<?php

namespace Camphi\BaseApiClient;

abstract class AbstractDataModel
{

    public function __construct(
        protected array $_data = []
    )
    {
    }

    public function getData(string $name, $default = null): mixed
    {
        if ('' === $name) {
            return $this->_data;
        }

        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }

        $sname = $this->camelToSnake($name);
        if (array_key_exists($sname, $this->_data)) {
            return $this->_data[$sname];
        }
        
        return $default;
    }

    public function setData(string $name, mixed $value): void
    {
        $sname = $this->camelToSnake($name);
        $this->_data[$sname] = $value;
    }

    public function __call($name, $args)
    {
        $cname = lcfirst(substr($name, 3));
        return match (substr($name, 0, 3)) {
            'get' => $this->getData($cname, $args[0]),
            'set' => $this->setData($cname, $args[0]),
        };
    }

    public function __isset($name)
    {
        $sname = $this->camelToSnake($name);
        return isset($this->_data[$name]) ?: isset($this->_data[$sname]);
    }

    protected function camelToSnake(string $str): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $str));
    }
    
    public function isEmpty(): bool
    {
        return empty($this->_data);
    }
}