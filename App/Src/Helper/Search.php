<?php

namespace Src\Helper;

class Search
{
    public static function binary(array $data, string $key, string $value)
    {
        $start = 0;
        $end = count($data) - 1;

        while ($start <= $end) {
            $mid = floor(($start + $end) / 2);

            if ($data[$mid][$key] == $value) {
                return $mid;
            } elseif ($data[$mid][$key] < $value) {
                $start = $mid + 1;
            } else {
                $end = $mid - 1;
            }
        }

        return null;
    }
}