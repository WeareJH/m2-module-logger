<?php

namespace Jh\Logger\Model;

use Jh\Logger\Model\Handler\HandlerInterface;
use Jh\Logger\Service\MailService;

class Alert
{
    private $mailService;
    private $subject;
    private $message;
    private $exception;


    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject ?? '';
    }

    /**
     * @return \Exception|null
     */
    public function getException(): ?\Exception
    {
        return $this->exception;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message ?? '';
    }

    /**
     * @param \Exception|null $exception
     */
    public function setException(?\Exception $exception): void
    {
        $this->exception = $exception;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }
}
