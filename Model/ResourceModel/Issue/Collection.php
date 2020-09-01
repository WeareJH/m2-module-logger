<?php


namespace Jh\Logger\Model\ResourceModel\Issue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Jh\Logger\Model\Issue;
use Jh\Logger\Model\ResourceModel\Issue as IssueResource;

class Collection extends AbstractCollection
{
    protected function _construct() // @codingStandardsIgnoreLine
    {
        $this->_init(Issue::class, IssueResource::class);
    }
}
