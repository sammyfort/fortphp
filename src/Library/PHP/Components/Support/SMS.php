<?php


namespace Fort\PHP\Support;



class SMS
{
    protected function send(array $data){
        return Http::post('https://api.velstack.com',
            $data,
            [
                'Accept'=> 'application/json',
                'Authorization'=> "Bearer ". $_ENV['SMS_API_KEY']
            ]);
    }

    public function sendQuick($recipient, string $message){
        $data = [
            'sender'=> $_ENV['SMS_SENDER_ID'],
            'recipient'=> $recipient,
            'message'=> $message,
            'title'=> 'Fort PHP Package Test'
        ];

        return $this->send($data);
    }



}