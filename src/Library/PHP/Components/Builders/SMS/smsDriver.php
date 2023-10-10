<?php


namespace Fort\PHP\Builders\SMS;


use Exception;
use Fort\PHP\Contracts\SMS\InitialiseProviders as Providers;



class smsDriver extends Providers
{

        protected static function forwardToProvider($recipient, $message): mixed
        {
            $path =  __DIR__. "/../../../../../../../../../.env";
            if (!file_exists($path)){
                return new \RuntimeException('.env file is missing from project',404);
            }
            if ($_ENV['SMS_DRIVER'] == null or $_ENV['SMS_DRIVER'] == '' ){
                return new \RuntimeException('Make you have set [SMS_DRIVER] variable in .env file and not empty',404);
            }

            if ($_ENV['SMS_DRIVER'] == 'velstack'){
                return   (new Providers())->toVelstack($recipient, $message);
            }

            if ($_ENV['SMS_DRIVER'] == 'vonage'){
                return  (new Providers())->toVonage($recipient, $message);
            }
            return null;
        }


}