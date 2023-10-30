<?php
/**
 * Helper class that provides easy access to useful php functions.
 *
 * @author      Samuel Transporter <sam@velstack.com>
 * @link        https://github.com/sammyfort/FortPHP
 * @license     MIT
 *
 */

use Fort\PHP\Arr;
use Fort\PHP\Concerns\Env;

if (! function_exists('head')) {
    /**
     * Get the first element of an array. Useful for method chaining.
     *
     * @param  array  $array
     * @return mixed
     */
    function head($array)
    {
        return reset($array);
    }
}

if (! function_exists('last')) {
    /**
     * Get the last element from an array.
     *
     * @param  array  $array
     * @return mixed
     */
    function last($array)
    {
        return end($array);
    }
}

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @param  mixed  ...$args
     * @return mixed
     */
    function value($value, ...$args)
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}

if (! function_exists('throw_if')) {
    /**
     * Throw the given exception if the given condition is true.
     *
     * @template TException of \Throwable
     *
     * @param  mixed  $condition
     * @param  TException|class-string<TException>|string  $exception
     * @param  mixed  ...$parameters
     * @return mixed
     *
     * @throws TException
     */
    function throw_if($condition, $exception = 'RuntimeException', ...$parameters)
    {
        if ($condition) {
            if (is_string($exception) && class_exists($exception)) {
                $exception = new $exception(...$parameters);
            }

            throw is_string($exception) ? new RuntimeException($exception) : $exception;
        }

        return $condition;
    }

    if (! function_exists('transform')) {
        /**
         * Transform the given value if it is present.
         *
         * @template TValue of mixed
         * @template TReturn of mixed
         * @template TDefault of mixed
         *
         * @param  TValue  $value
         * @param  callable(TValue): TReturn  $callback
         * @param  TDefault|callable(TValue): TDefault|null  $default
         * @return ($value is empty ? ($default is null ? null : TDefault) : TReturn)
         */
        function transform($value, callable $callback, $default = null)
        {
            if (filled($value)) {
                return $callback($value);
            }

            if (is_callable($default)) {
                return $default($value);
            }

            return $default;
        }
    }

    if (! function_exists('windows_os')) {
        /**
         * Determine whether the current environment is Windows based.
         *
         * @return bool
         */
        function windows_os()
        {
            return PHP_OS_FAMILY === 'Windows';
        }
    }

    if (! function_exists('with')) {
        /**
         * Return the given value, optionally passed through the given callback.
         *
         * @template TValue
         * @template TReturn
         *
         * @param  TValue  $value
         * @param  (callable(TValue): (TReturn))|null  $callback
         * @return ($callback is null ? TValue : TReturn)
         */
        function with($value, callable $callback = null)
        {
            return is_null($callback) ? $value : $callback($value);
        }
    }

    if (! function_exists('env')) {
        /**
         * Gets the value of an environment variable.
         *
         * @param  string  $key
         * @param  mixed  $default
         * @return mixed
         */
        function env($key, $default = null)
        {
            return Env::get($key, $default);
        }
    }

    if (! function_exists('data_get')) {
        /**
         * Get an item from an array or object using "dot" notation.
         *
         * @param  mixed  $target
         * @param  string|array|int|null  $key
         * @param  mixed  $default
         * @return mixed
         */
        function data_get($target, $key, $default = null)
        {
            if (is_null($key)) {
                return $target;
            }

            $key = is_array($key) ? $key : explode('.', $key);

            foreach ($key as $i => $segment) {
                unset($key[$i]);

                if (is_null($segment)) {
                    return $target;
                }

                if ($segment === '*') {
                      if(! is_iterable($target)) {
                        return value($default);
                    }

                    $result = [];

                    foreach ($target as $item) {
                        $result[] = data_get($item, $key);
                    }

                    return in_array('*', $key) ? Arr::collapse($result) : $result;
                }

                if (Arr::accessible($target) && Arr::exists($target, $segment)) {
                    $target = $target[$segment];
                } elseif (is_object($target) && isset($target->{$segment})) {
                    $target = $target->{$segment};
                } else {
                    return value($default);
                }
            }

            return $target;
        }
    }

    if (! function_exists('data_set')) {
        /**
         * Set an item on an array or object using dot notation.
         *
         * @param  mixed  $target
         * @param  string|array  $key
         * @param  mixed  $value
         * @param  bool  $overwrite
         * @return mixed
         */
        function data_set(&$target, $key, $value, $overwrite = true)
        {
            $segments = is_array($key) ? $key : explode('.', $key);

            if (($segment = array_shift($segments)) === '*') {
                if (! Arr::accessible($target)) {
                    $target = [];
                }

                if ($segments) {
                    foreach ($target as &$inner) {
                        data_set($inner, $segments, $value, $overwrite);
                    }
                } elseif ($overwrite) {
                    foreach ($target as &$inner) {
                        $inner = $value;
                    }
                }
            } elseif (Arr::accessible($target)) {
                if ($segments) {
                    if (! Arr::exists($target, $segment)) {
                        $target[$segment] = [];
                    }

                    data_set($target[$segment], $segments, $value, $overwrite);
                } elseif ($overwrite || ! Arr::exists($target, $segment)) {
                    $target[$segment] = $value;
                }
            } elseif (is_object($target)) {
                if ($segments) {
                    if (! isset($target->{$segment})) {
                        $target->{$segment} = [];
                    }

                    data_set($target->{$segment}, $segments, $value, $overwrite);
                } elseif ($overwrite || ! isset($target->{$segment})) {
                    $target->{$segment} = $value;
                }
            } else {
                $target = [];

                if ($segments) {
                    data_set($target[$segment], $segments, $value, $overwrite);
                } elseif ($overwrite) {
                    $target[$segment] = $value;
                }
            }

            return $target;
        }
    }
}
