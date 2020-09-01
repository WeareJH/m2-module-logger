<?php

declare(strict_types=1);

namespace Jh\Logger\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Issue extends AbstractDb
{
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

    protected function _construct()
    {
        $this->_init('jh_logging_issue', 'issue_id');
    }

    public function cleanupOldData(\DateTime $cleanupDate)
    {
        $time       = $cleanupDate->format(self::MYSQL_DATE_FORMAT);
        $connection = $this->getConnection();
        $connection->delete($this->getMainTable(), ['timestamp <= ?' => $time]);
    }

    public function loadActive(string $type): int
    {
        $connection = $this->getConnection();
        $select     = $connection->select()
            ->from($this->getMainTable(), [$this->getIdFieldName()])
            ->where('type = ?', $type)
            ->where('is_active = ?', '1')
            ->limit(1);
        return (int) $connection->fetchOne($select);
    }
}
