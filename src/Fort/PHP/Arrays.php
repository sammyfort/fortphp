<?php


namespace Fort\PHP;


class Arrays
{
    /**
     * Parse about any Mathematics calculations
     * @param array $haystack [required] <p>
     * The percentage rate.
     * @return string|int|float|bool returns the maximum element in the array
     */
    public static function maximum(array $haystack): string|int|float|bool
    {
        return array_search(max($haystack), $haystack);
    }

    /**
     * Parse about any Mathematics calculations
     * @param array $haystack [required] <p>
     * The percentage rate.
     * @return string|int|float|bool returns the maximum element in the array
     */
    public static function minimum(array $haystack): string|int|float|bool
    {
        return array_search(min($haystack), $haystack);
    }

    /**
     * Parse about any Mathematics calculations
     * @param array $haystack [required] <p>
     * The percentage rate.
     * @return mixed returns the value of the needle element in the array
     * @example  $haystack = [
     * ['everett'=> 1, 'phil'=> 2, 'fort'=>3]
     * ];
     * returns 1;
     */
    public static function childValue(array $haystack, mixed $needle): mixed
    {
        $currentMax = NULL;
        foreach ($haystack as $arr) {
            foreach ($arr as $key => $value) {
                if ($key == $needle && ($value >= $currentMax)) {
                    $currentMax = $value;
                }
            }
        }

        return $currentMax;
    }

}