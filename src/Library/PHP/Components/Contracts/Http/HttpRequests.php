<?php


namespace Fort\PHP\Contracts\Http;


use Fort\PHP\Components\Contracts\Http\Curl;

trait HttpRequests
{
    protected static function getRequest(string $uri, array $headers = null, array $config = null)
    {
        $client = new Curl();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => $config['return_transfer'] ?: true,
            CURLOPT_ENCODING => $config['encoding'] ?: "",
            CURLOPT_MAXREDIRS => $config['maxredirs'] ?: 10,
            CURLOPT_TIMEOUT => $config['timeout'] ?: 30,
            CURLOPT_HTTP_VERSION => $config['http_version'] ?: CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $client->setHeaders($headers) ?: ["Content-Type: application/json"],
        ));

        return $client->response($curl);
    }

    protected static function postRequest(string $uri, array $data, array $headers = null)
    {
        //open connection
        $client = new Curl();
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $client->setHeaders($headers) ?: ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
       return $client->response($ch);
    }

    protected static function putRequest(string $uri, array $data, array $headers=null)
    {
        //open connection
        $client = new Curl();
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $client->setHeaders($headers) ?: ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        return $client->response($ch);
    }

    protected static function deleteRequest(string $uri, array $headers=null){
        $client = new Curl();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $client->setHeaders($headers) ?: ["Content-Type: application/json"]);
        return $client->response($ch);

    }

    protected static function multipart(string $uri, array $data, array $headers= null){

        $ch = curl_init();
        $client = new Curl();

        curl_setopt($ch, CURLOPT_HTTPHEADER, $client->setHeaders($headers) ?? ["Content-Type: multipart/form-data","Accept: multipart/form-data"]);
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        return $client->response($ch);

    }

}