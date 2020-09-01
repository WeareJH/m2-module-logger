<?php

namespace Jh\Logger\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Jh\Logger\Api\LogRepositoryInterface;
use Jh\Logger\Api\Data\LogInterface;
use Jh\Logger\Model\ResourceModel\Log\CollectionFactory;

class LogRepository implements LogRepositoryInterface
{

    private $resource;
    private $logFactory;
    private $collectionFactory;
    private $collectionProcessor;
    private $searchResultsFactory;

    public function __construct(
        \Jh\Logger\Model\ResourceModel\Log $resource,
        \Jh\Logger\Api\Data\LogInterfaceFactory $logFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource             = $resource;
        $this->logFactory           = $logFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->collectionProcessor  = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function get(string $type): LogInterface
    {
        $log = $this->logFactory->create();
        $this->resource->load($log, $type, 'type');
        if (!$log->getId()) {
            throw new NoSuchEntityException(__('Log not found with type %1', $type));
        }
        return $log;
    }

    /**
     * @inheritdoc
     */
    public function getById(int $entityId): LogInterface
    {
        $log = $this->logFactory->create();
        $this->resource->load($log, $entityId);
        if (!$log->getId()) {
            throw new NoSuchEntityException(__('Log not found with ID %1', $entityId));
        }
        return $log;
    }

    /**
     * @inheritdoc
     */
    public function save(LogInterface $log): LogInterface
    {
        try {
            $this->resource->save($log);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save Log'), $e);
        }
        return $log;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        /** @var \Jh\Logger\Model\ResourceModel\Log\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(LogInterface $log): bool
    {
        try {
            $this->resource->delete($log);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete log'), $e);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $logId): bool
    {
        $log = $this->getById($logId);
        return $this->delete($log);
    }
}
