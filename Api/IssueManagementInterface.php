<?php

namespace Jh\Logger\Api;

interface IssueManagementInterface
{
    /**
     * @param string $type
     * @return int
     */
    public function isOpen(string $type): int;

    /**
     * Open issue
     * @param string $type
     * @throws \Exception
     * @return int
     */
    public function open(string $type): int;

    /**
     * @param \DateTime $cleanDate
     * @return void
     */
    public function clean(\DateTime $cleanDate);
}
