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
