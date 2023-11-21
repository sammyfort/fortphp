<?php


namespace Fort\PHP\Builders\Mailer;



use Fort\PHP\Builders\Application;
use Fort\PHP\Http\Response;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer as Service;

class Mailer
{


    protected function transport()
    {
        return Transport::fromDsn("smtp://support@velstack.com:platinum@support@mail.velstack.com:465");

    }

    protected function mailer()
    {
        return (new Service($this->transport()));
    }



    public function handle($fromAddress, $fromName, $toAddress, $toName, $ccAddress, $replyToAddress, $priority, $subject)
    {
        $email = (new Email());

           $email->from(new Address($fromName, $fromAddress));
           $email->to(new Address($toAddress, $toName));
           isset($ccAddress) ? $email->cc() :  '';
           isset($replyToAddress) ? $email->replyTo() : exit();
           $email->bcc();
           $email->subject($subject);
           $email->priority($priority ?? 1);
           $email->text('The email body');
           $email->html('<p> Hello word </p>');

        $this->mailer()->send($email);

         return  Response::set('Success', 200);


    }


}