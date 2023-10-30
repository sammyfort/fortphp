<?php


namespace Fort\PHP\Contracts\Http;



abstract class Fort
{
    use  HttpRequests;



    /**
     * Perform http get request
     * </p>
     * @param string $uri
     * @param array|null $headers
     * @param array|null $config

     */

    public static function get(string $uri, array $headers = null, array $config = null)
    {

        return static::getRequest($uri, $headers, $config);
    }

    /**
     * Perform http post request
     * </p>
     * @param string $uri
     * @param array $data
     * @param array|null $headers
     *  * @return mixed
     */

    public static function post(string $uri, array $data,  array $headers = null): mixed
    {

        return static::postRequest($uri, $data, $headers);
    }

    /**
     * Perform http put request
     * </p>
     * @param string $uri
     * @param array $data
     * @param array|null $headers
     * @return mixed
     */

    protected static function put(string $uri, array $data,  array $headers = null)
    {

        return static::putRequest($uri, $data, $headers);
    }

    /**
     * Perform http delete request
     * </p>
     * @param string $uri
     * @param array|null $headers
     * @return bool|string
     *  * @return mixed
     */

    protected static function delete(string $uri, array $headers = null)
    {
        return static::deleteRequest($uri, $headers);
    }

    /**
     * Perform http multi form request
     * </p>
     * @param string $uri
     * @param array $data
     * @param array|null $headers
     *  * @return mixed

     */

    protected static function asPostMultipart(string $uri, array $data, array $headers = null)
    {
        return static::multipart($uri, $data, $headers);
    }



}