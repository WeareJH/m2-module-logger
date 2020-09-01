<?php

namespace Jh\Logger\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LogSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Jh\Logger\Api\Data\LogInterface[]
     */
    public function getItems();

    /**
     * @param \Jh\Logger\Api\Data\LogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
