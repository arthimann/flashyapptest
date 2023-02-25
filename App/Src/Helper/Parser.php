<?php

namespace Src\Helper;

class Parser
{
    /**
     * Parse data to JSON
     * @param $context
     * @return false|string
     */
    public static function toJson($context)
    {
        return json_encode($context);
    }

    /**
     * Parse data from JSON
     * @param $context
     * @return mixed
     */
    public static function fromJson($context)
    {
        return json_decode($context, JSON_PRETTY_PRINT);
    }
}