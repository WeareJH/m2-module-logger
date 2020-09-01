<?php

namespace Jh\Logger\Api;

interface LoggerManagementInterface
{
    /**
     * Add a new event to the log
     *
     * @param string $type
     * @param string $message
     * @param string $identifierLabel
     * @param string $identifierValue
     * @param int $severity
     * @param bool $createIssue
     * @param \Exception $exception
     * @return bool
     */
    public function addEvent(
        string $type,
        string $message = '',
        string $identifierLabel = '',
        string $identifierValue = '',
        int $severity = 1,
        bool $createIssue = true,
        \Exception $exception = null
    ): bool;

    /**
     * @param \DateTime $cleanDate
     */
    public function clean(\DateTime $cleanDate);

    /**
     * @param string $type
     * @return bool
     */
    public function closeIssue(string $type): bool;
}
