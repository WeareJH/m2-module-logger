<?php

declare(strict_types=1);

namespace Jh\Logger\Model;

use Magento\Framework\Model\AbstractModel;
use Jh\Logger\Api\Data\LogInterface;
use Jh\Logger\Model\ResourceModel\Log as LogResource;

class Log extends AbstractModel implements LogInterface
{
    public function _construct()
    {
        $this->_init(LogResource::class);
    }

    /**
     * @return int|null
     */
    public function getIssueId()
    {
        return $this->getData(LogInterface::ISSUE_ID);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getData(LogInterface::TYPE) ?? '';
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getData(LogInterface::MESSAGE) ?? '';
    }

    /**
     * @return int
     */
    public function getSeverity(): int
    {
        return $this->getData(LogInterface::SEVERITY);
    }

    /**
     * @return string|null
     */
    public function getIdentifierLabel(): ?string
    {
        return $this->getData(LogInterface::IDENTIFIER_LABEL);
    }

    /**
     * @return string|null
     */
    public function getIdentifierValue(): ?string
    {
        return $this->getData(LogInterface::IDENTIFIER_VALUE);
    }

    /**
     * @param int|null $issueId
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setIssueId(?int $issueId): LogInterface
    {
        $this->setData(LogInterface::ISSUE_ID, $issueId);
        return $this;
    }

    /**
     * @param string $type
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setType(string $type): LogInterface
    {
        $this->setData(LogInterface::TYPE, $type);
        return $this;
    }

    /**
     * @param string $message
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setMessage(string $message): LogInterface
    {
        $this->setData(LogInterface::MESSAGE, $message);
        return $this;
    }

    /**
     * @param int $severity
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setSeverity(int $severity): LogInterface
    {
        $this->setData(LogInterface::SEVERITY, $severity);
        return $this;
    }

    /**
     * @param string|null $identifierLabel
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setIdentifierLabel(?string $identifierLabel): LogInterface
    {
        $this->setData(LogInterface::IDENTIFIER_LABEL, $identifierLabel);
        return $this;
    }

    /**
     * @param string|null $identifierValue
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function setIdentifierValue(?string $identifierValue): LogInterface
    {
        $this->setData(LogInterface::IDENTIFIER_VALUE, $identifierValue);
        return $this;
    }
}
