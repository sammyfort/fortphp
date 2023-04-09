<?php


if (!function_exists('fort_max'))
{
    function fort_max(mixed... $values): mixed
    {
        return max($values);
    }
}

if (!function_exists('fort_square_root_of'))
{
    function fort_square_root_of(int|float $value): int|float
    {
        return sqrt($value);
    }
}

if (!function_exists('fort_percentage')){
    function fort_percentage(int|float $percentage, int|float $value):int|float
    {
        return  $percentage / 100 * $value;
    }
}

