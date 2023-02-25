<?php

namespace Src\Utils;

class Serializer implements \JsonSerializable
{
    public array $items;

    public function __construct(array $arr)
    {
        $this->items = $arr;
    }

    public function jsonSerialize()
    {
        return $this->items;
    }
}