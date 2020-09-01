<?php

declare(strict_types=1);

namespace Jh\Logger\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Log extends AbstractDb
{
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

    protected function _construct()
    {
        $this->_init('jh_logging', 'logger_id');
    }

    public function cleanupOldData(\DateTime $cleanupDate)
    {
        $time = $cleanupDate->format(self::MYSQL_DATE_FORMAT);
        $connection = $this->getConnection();
        $connection->delete($this->getMainTable(), ['timestamp <= ?' => $time]);
    }
}
