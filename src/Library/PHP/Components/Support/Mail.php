<?php


namespace Fort\PHP\Support;


use Fort\PHP\Builders\Mailer\Mailer;
use Fort\Exception\ErrorHandler;


class Mail extends ErrorHandler
{


    protected string $fromAddress;
    protected ?string $fromName;
    protected string $toAddress;
    protected ?string $toName;
    protected string $subject;
    protected string $ccAddress;
    protected string $replyToAddress;
    protected string $replyToName;
    protected string $priority;
    protected mixed $attachment;


    public function from($address, $name = null)
    {
        $this->fromAddress = $address;
        $this->fromName = $name;
        return $this;

    }

    public function to($address, $name = null)
    {
        $this->toAddress = $address;
        $this->toName = $name;
        return $this;

    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;

    }

    public function cc($address)
    {
        if (!empty($this->ccAddress)){
            $this->ccAddress = $address;
            return $this;
        }


    }



    public function replyTo($address, $name = '')
    {
        $this->replyToAddress = $address;
        $this->replyToName = $name;
        return $this;


    }

    public function attach($filePath)
    {
        $this->attachment = $filePath;
        return $this;

    }

    public function send()
    {
        try {
            return (new Mailer())->handle(
                $this->fromAddress,
                $this->fromName,
                $this->toAddress,
                $this->toName,
                $this->ccAddress,
                $this->replyToAddress,
                $this->priority,
                $this->subject,


            );
        } catch (\Exception $e) {
            return $this->throw($e->getMessage(), 500);
        }
    }
}