<?php

namespace Jh\Logger\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Jh\Logger\Api\Data\LogInterface;

interface LogRepositoryInterface
{

    /**
     * @param string $type
     * @return \Jh\Logger\Api\Data\LogInterface
     * @throws NoSuchEntityException
     */
    public function get(string $type) : LogInterface;

    /**
     * @param int $entityId
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function getById(int $entityId) : LogInterface;

    /**
     * @return \Jh\Logger\Api\Data\LogInterface
     */
    public function save(LogInterface $log) : LogInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Jh\Logger\Api\Data\LogSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * @param LogInterface $log
     * @return bool
     */
    public function delete(LogInterface $log): bool;


    /**
     * @param int $logId
     * @return bool
     */
    public function deleteById(int $logId): bool;
}
