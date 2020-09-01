<?php

namespace Jh\Logger\Api\Data;

interface IssueInterface
{
    public const TYPE      = 'type';
    public const IS_ACTIVE = 'is_active';

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function getIsActive(): bool;

    /**
     * @param string $type
     * @return \Jh\Logger\Api\Data\IssueInterface
     */
    public function setType(string $type): IssueInterface;

    /**
     * @param bool $isActive
     * @return \Jh\Logger\Api\Data\IssueInterface
     */
    public function setIsActive(bool $isActive): IssueInterface;
}
