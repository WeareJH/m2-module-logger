<?php

namespace Jh\Logger\Model\Exception;

abstract class ExceptionAbstract extends \RuntimeException
{
    /**
     * Array of alert contacts
     *
     * @var array
     */
    protected $alertContacts = [];

    public function getAlertContacts() : array
    {
        return $this->alertContacts;
    }
}
