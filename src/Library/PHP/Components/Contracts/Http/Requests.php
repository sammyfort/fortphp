<?php


namespace Fort\PHP\Contracts\Http;


trait Requests
{
    protected static function getRequest(string $uri, array $headers = null, array $config = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => $config['return_transfer'] ?: true,
            CURLOPT_ENCODING => $config['encoding'] ?: "",
            CURLOPT_MAXREDIRS => $config['maxredirs'] ?: 10,
            CURLOPT_TIMEOUT => $config['timeout'] ?: 30,
            CURLOPT_HTTP_VERSION => $config['http_version'] ?: CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers ?: ["Content-Type" => "application/json"],
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        }
        return $response;
    }

    protected static function postRequest(string $uri, array $data, array $headers)
    {
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers ?: ["Content-Type" => "application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        $err = curl_error($ch);
        if ($err) {
            return $err;
        }
        return $result;
    }

    protected static function putRequest(string $uri, array $data, array $headers=null)
    {
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers ?: ["Content-Type" => "application/json"]);

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $err = curl_error($ch);
        $result = curl_exec($ch);
        if ($err){
            return $err;
        }
        return $result;
    }

}