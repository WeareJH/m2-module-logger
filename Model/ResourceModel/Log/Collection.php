<?php

namespace Jh\Logger\Model\ResourceModel\Log;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Jh\Logger\Model\Log;
use Jh\Logger\Model\ResourceModel\Log as LogResource;

class Collection extends AbstractCollection
{
    protected function _construct() // @codingStandardsIgnoreLine
    {
        $this->_init(Log::class, LogResource::class);
    }
}
