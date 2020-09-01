<?php

namespace Jh\Logger\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface IssueSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Jh\Logger\Api\Data\IssueInterface[]
     */
    public function getItems();

    /**
     * @param \Jh\Logger\Api\Data\IssueInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
