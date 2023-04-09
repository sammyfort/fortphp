<?php


if (!function_exists('fort_max_array_value'))
{
    function fort_max_array_value(array $collection):string|int|float|bool
    {
        return  array_search(max($collection), $collection);

    }
}


if (!function_exists('fort_min_array_value'))
{
    function fort_min_array_value(array $collection):string|int|float|bool
    {
        return  array_search(min($collection), $collection);

    }
}

if (!function_exists('fortMaxArrayInArrayValue'))
{
    function fortMaxArrayInArrayValue($array, $keyToSearch)
    {
        $currentMax = NULL;
        foreach($array as $arr)
        {
            foreach($arr as $key => $value)
            {
                if ($key == $keyToSearch && ($value >= $currentMax))
                {
                    $currentMax = $value;
                }
            }
        }

        return $currentMax;
    }
}


