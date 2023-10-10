<?php


namespace Fort\PHP\Contracts\SMS;


use Fort\PHP\Support\Http;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class InitialiseProviders
{
    protected function vonageCredentials(): Client
    {
        $basic  = new Basic($_ENV['SMS_API_KEY'], $_ENV['SMS_SECRET_KEY']);
        return new Client($basic);
    }

    protected function toVonage($recipient, string $message){
        $result = $this->vonageCredentials()->sms()->send(
              new SMS($recipient, $_ENV['SMS_SENDER_ID'], $message)
          );

        $message = $result->current();

        if ($message->getStatus() == 0) {
            return "The message was sent successfully\n";
        }

        return "The message failed with status: " . $message->getStatus() . "\n";
    }

    protected function forwardToVelstack(array $data){
        return Http::post('https://sms.velstack.com/api/quick/sms',
            $data,
            [
                "Accept: application/json",
                "Authorization: Bearer {$_ENV['SMS_API_KEY']}"
            ]);
    }

    protected function toVelstack($recipient, string $message){
        $data = [
            'sender'=> $_ENV['SMS_SENDER_ID'],
            'recipient'=> $recipient,
            'message'=> $message,
            'title'=> substr($message, 0, 3)
        ];

        return $this->forwardToVelstack($data);
    }

}