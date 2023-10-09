<?php


namespace Fort\PHP\Builders\SMS;


use Exception;
use Fort\PHP\Contracts\SMS\InitialiseProviders as Providers;


class smsDriver extends Providers
{

        protected function forwardToProvider($recipient, $message): mixed
        {
           // $path =  __DIR__. "/../../../../../../../../../../.env";
            $path2 =  __DIR__. "/.env";
            if (!file_exists($path2)){
                return new Exception('.env file is missing from project',404);
            }
            if ($_ENV['SMS_DRIVER'] == null or $_ENV['SMS_DRIVER'] == '' ){
                return new Exception('Make you have set [SMS_DRIVER] variable in .env file and not empty',404);
            }

            if ($_ENV['SMS_DRIVER'] == 'velstack'){
                return   (new Providers())->toVelstack($recipient, $message);
            }

            if ($_ENV['SMS_DRIVER'] == 'vonage'){
                return   (new Providers())->toVonage($recipient, $message);
            }
            return null;

        }


}