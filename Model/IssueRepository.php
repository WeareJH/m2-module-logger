<?php

namespace Jh\Logger\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Jh\Logger\Api\Data\IssueInterfaceFactory;
use Jh\Logger\Api\IssueRepositoryInterface;
use Jh\Logger\Api\Data\IssueInterface;
use Jh\Logger\Model\ResourceModel\Issue\CollectionFactory;

class IssueRepository implements IssueRepositoryInterface
{

    private $resource;
    private $issueFactory;
    private $collectionFactory;
    private $collectionProcessor;
    private $searchResultFactory;
    private $searchResultsFactory;

    public function __construct(
        \Jh\Logger\Model\ResourceModel\Issue $resource,
        IssueInterfaceFactory $issueFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource             = $resource;
        $this->issueFactory         = $issueFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->collectionProcessor  = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function get(string $type): IssueInterface
    {
        $issue   = $this->issueFactory->create();
        $issueId = $this->resource->loadActive($type);
        $this->resource->load($issue, $issueId);

        if (!$issue->getId()) {
            throw new NoSuchEntityException(__('Issue not found with type %1', $type));
        }
        return $issue;
    }

    /**
     * @inheritdoc
     */
    public function getById(int $entityId): IssueInterface
    {
        $issue = $this->issueFactory->create();
        $this->resource->load($issue, $entityId);
        if (!$issue->getId()) {
            throw new NoSuchEntityException(__('Issue not found with ID %1', $entityId));
        }
        return $issue;
    }

    /**
     * @inheritdoc
     */
    public function save(IssueInterface $issue): IssueInterface
    {
        try {
            $this->resource->save($issue);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save Issue'), $e);
        }
        return $issue;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var \Jh\Logger\Model\ResourceModel\Issue\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function delete(IssueInterface $issue): bool
    {
        try {
            $this->resource->delete($issue);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete issue'), $e);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteById(int $issueId): bool
    {
        $issue = $this->getById($issueId);
        return $this->delete($issue);
    }
}
