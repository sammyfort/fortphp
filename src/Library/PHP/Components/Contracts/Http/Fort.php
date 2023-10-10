<?php


namespace Fort\PHP\Contracts\Http;
use Fort\PHP\Builders\SMS\smsDriver as Driver;
use Fort\PHP\Contracts\Http\Requests as HttpRequest;


abstract class Fort extends Driver
{

    use HttpRequest;

    /**
     * Connect to the database set in the .env file
     * </p>
     * @param $recipient
     * @param string $message
     * @return mixed
     */

    public static function send($recipient, string $message): mixed
    {
        return self::forwardToProvider($recipient, $message);
    }

    /**
     * Perform http get request
     * </p>
     * @param string $uri
     * @param array|null $headers
     * @param array|null $config
     * @return bool|string
     */

    protected static function get(string $uri,  array $headers= null, array $config = null): bool|string
    {

        return static::getRequest($uri, $headers, $config);
    }

    /**
     * Perform http post request
     * </p>
     * @param string $uri
     * @param array $data
     * @param array|null $headers
     * @return bool|string
     */

    protected static function post(string $uri, array $data,  array $headers = null): bool|string
    {

        return static::postRequest($uri, $data, $headers);
    }

    /**
     * Perform http put request
     * </p>
     * @param string $uri
     * @param array $data
     * @param array|null $headers
     * @return bool|string
     */

    protected static function put(string $uri, array $data,  array $headers = null): bool|string
    {

        return static::putRequest($uri, $data, $headers);
    }

    /**
     * Perform http delete request
     * </p>
     * @param string $uri
     * @param array|null $headers
     * @return bool|string
     */

    protected static function delete(string $uri, array $headers = null): bool|string
    {
        return static::deleteRequest($uri, $headers);
    }

    /**
     * Perform http multi form request
     * </p>
     * @param string $uri
     * @param array $data
     * @param string|null $headers
     * @return bool|string
     */

    protected static function asPostMultipart(string $uri, array $data, array $headers = null): bool|string
    {
        return static::multipart($uri, $data, $headers);
    }

}