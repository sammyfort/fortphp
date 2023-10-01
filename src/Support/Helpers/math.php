<?php


if (!function_exists('fort_sum'))
{
    function fort_sum(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val + $second_val;
    }
}

if (!function_exists('fort_sub'))
{
    function fort_sub(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val - $second_val;
    }
}

if (!function_exists('fort_multiply'))
{
    function fort_multiply(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val * $second_val;
    }

}

if (!function_exists('fort_div'))
{
    function fort_div(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val / $second_val;
    }
}

if (!function_exists('fort_expo'))
{
    function fort_expo(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val ** $second_val;
    }
}

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

