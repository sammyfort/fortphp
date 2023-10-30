<?php


namespace Fort\PHP\Components\Contracts\Http;


class Curl
{

    public function setHeaders(array $headers = null){
        $header = [];
        if (is_array($headers)) {
            foreach ($headers as $key => $value) {
                 array_push($header,"$key: $value" );
            }

            return $header;
        }
        return null ;
    }

    public function response($curl)
    {
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $err;
        }
        return $response;
    }

}