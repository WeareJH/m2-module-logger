<?php

declare(strict_types=1);

namespace Jh\Logger\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$items) {
                $items['is_active'] = $items['is_active'] ? 'Active' : 'Resolved';
            }
        }
        return $dataSource;
    }
}
