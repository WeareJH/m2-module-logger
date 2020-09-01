<?php

namespace Jh\Logger\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Jh\Logger\Api\Data\IssueInterface;

interface IssueRepositoryInterface
{

    /**
     * @param string $type
     * @return \Jh\Logger\Api\Data\IssueInterface
     * @throws NoSuchEntityException
     */
    public function get(string $type) : IssueInterface;


    /**
     * @param int $entityId
     * @return \Jh\Logger\Api\Data\IssueInterface
     */
    public function getById(int $entityId) : IssueInterface;

    /**
     * @return \Jh\Logger\Api\Data\IssueInterface
     */
    public function save(IssueInterface $issue) : IssueInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Jh\Logger\Api\Data\IssueSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;


    /**
     * @param IssueInterface $issue
     * @return bool
     */
    public function delete(IssueInterface $issue): bool;


    /**
     * @param int $issueId
     * @return bool
     */
    public function deleteById(int $issueId): bool;
}
