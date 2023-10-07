<?php


namespace Fort\PHP;

use Fort\Exception\LogicException;

class Math
{
    /**
     * @throws LogicException
     */
    protected function __construct()
    {
        throw new LogicException('Invalid instantiation');
    }

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
    /**
     * Parse about any Mathematics calculations
     * @param int|float $percentage [required] <p>
     * The percentage rate.
     * </p>
     * @param int|float $size [required] <p>
     * The total size of data to look for the percentage
     * </p>
     * @return int|float returns $percentage on $size
     */
    public static function percentage(int|float $percentage, int|float $size): int|float
    {
        return  $percentage / 100 * $size;
    }
    /**
     * Parse about any Mathematics calculations

     * The percentage rate.
     * </p>
     * @param int|float $number [required] <p>
     * The total size of data to look for the percentage
     * </p>
     * @return int|float returns $percentage on $size
     */
    public static function sqrRoot(int|float $number): int|float
    {
        return   sqrt($number);
    }
    /**
     * Parse about any Mathematics calculations
     * @param mixed $values [required] <p>
     * The maximum number .
     * </p>
     * @return int returns the maximum value in the values param of the first and the second params
     */
    public static function max(mixed $values): mixed
    {
        return max($values);
    }

    /**
     * Parse about any Mathematics calculations
     * @param mixed $values [required] <p>
     * The minimum number.
     * </p>
     * @return int returns the minimum value in the values param of the first and the second params
     */
    public static function min(mixed $values): mixed
    {
        return min($values);
    }




}