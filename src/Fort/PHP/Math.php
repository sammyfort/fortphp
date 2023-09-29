<?php


namespace Fort\PHP;


class Math
{
    /**
     * Parse about any Mathematics calculations
     * @param int|float $first_val [required] <p>
     * The number to sum.
     * </p>
     * @param int|float $second_val [required] <p>
     * The second to sum with the first number
     * </p>
     * @return int|float returns addition of the first and the second params
     */
    public static function sum(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val + $second_val;
    }

    /**
     * Parse about any Mathematics calculations
     * @param int|float $first_val [required] <p>
     * The number to sum.
     * </p>
     * @param int|float $second_val [required] <p>
     * The second to sum with the first number
     * </p>
     * @return int|float returns subtraction of the first and the second params
     */
    public static function sub(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val - $second_val;
    }

    /**
     * Parse about any Mathematics calculations
     * @param int|float $first_val [required] <p>
     * The number to sum.
     * </p>
     * @param int|float $second_val [required] <p>
     * The second to sum with the first number
     * </p>
     * @return int|float returns multiplication of the first and the second params
     */
    public static function mul(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val * $second_val;
    }

    /**
     * Parse about any Mathematics calculations
     * @param int|float $first_val [required] <p>
     * The number to sum.
     * </p>
     * @param int|float $second_val [required] <p>
     * The second to sum with the first number
     * </p>
     * @return int|float returns division of the first and the second params
     */
    public static function div(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val / $second_val;
    }

    /**
     * Parse about any Mathematics calculations
     * @param int|float $first_val [required] <p>
     * The number to sum.
     * </p>
     * @param int|float $second_val [required] <p>
     * The second to sum with the first number
     * </p>
     * @return int|float returns exponential of the first and the second params
     */
    public static function expo(int|float $first_val, int|float $second_val): int|float
    {
        return $first_val ** $second_val;
    }


}