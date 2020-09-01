<?php

declare(strict_types=1);

namespace Jh\Logger\Model;

use Magento\Framework\Model\AbstractModel;
use Jh\Logger\Api\Data\IssueInterface;
use Jh\Logger\Model\ResourceModel\Issue as IssueResource;

class Issue extends AbstractModel implements IssueInterface
{
    public function _construct()
    {
        $this->_init(IssueResource::class);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getData(IssueInterface::TYPE) ?? '';
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->getData(IssueInterface::IS_ACTIVE);
    }

    /**
     * @param string $type
     * @return \Jh\Logger\Api\Data\IssueInterface
     */
    public function setType(string $type): IssueInterface
    {
        $this->setData(IssueInterface::TYPE, $type);
        return $this;
    }

    /**
     * @param bool $isActive
     * @return \Jh\Logger\Api\Data\IssueInterface
     */
    public function setIsActive(bool $isActive): IssueInterface
    {
        $this->setData(IssueInterface::IS_ACTIVE, $isActive);
        return $this;
    }
}
