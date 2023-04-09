<?php
if (!function_exists('fort_string'))
{
    function fort_string(int $length): string
    {
        $str = random_bytes($length);
        $str = base64_encode($str);
        $str = str_replace(["+", "/", "="], "", $str);
        return substr($str, 0, $length);

    }
}
