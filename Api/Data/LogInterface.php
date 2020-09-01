<?php

namespace Jh\Logger\Api\Data;

interface LogInterface
{
    public const LOGGER_ID        = 'logger_id';
    public const ISSUE_ID         = 'issue_id';
    public const TYPE             = 'type';
    public const MESSAGE          = 'message';
    public const SEVERITY         = 'severity';
    public const IDENTIFIER_LABEL = 'identifier_label';
    public const IDENTIFIER_VALUE = 'identifier_value';

    /**
     * @return int|null
     */
    public function getIssueId();

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return int
     */
    public function getSeverity(): int;

    /**
     * @return string|null
     */
    public function getIdentifierLabel(): ?string;

    /**
     * @return string|null
     */
    public function getIdentifierValue(): ?string;

    /**
     * @param int|null $issueId
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setIssueId(?int $issueId): LogInterface;

    /**
     * @param string $type
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setType(string $type): LogInterface;

    /**
     * @param string $message
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setMessage(string $message): LogInterface;

    /**
     * @param int $severity
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setSeverity(int $severity): LogInterface;

    /**
     * @param string|null $identifierLabel
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setIdentifierLabel(?string $identifierLabel): LogInterface;

    /**
     * @param string|null $identifierValue
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setIdentifierValue(?string $identifierValue): LogInterface;
}
