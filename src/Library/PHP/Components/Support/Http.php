<?php


namespace Fort\PHP\Support;


use Fort\PHP\Contracts\Http\Fort;

/**
 * @method static get(string $uri, array $headers = null, array $config = null)()
 * @method static post(string $uri, array $data, array $headers = null)
 * @method  static asPostMultipart(string $uri, array $data, string $headers = null)
 * @method static put(string $uri, array $data, array $headers = null)
 * @method static delete(string $uri, array $headers = null)
 */

final class Http extends Fort
{


}