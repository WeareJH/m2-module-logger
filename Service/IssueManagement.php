<?php

namespace Jh\Logger\Service;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Jh\Logger\Api\IssueManagementInterface;
use Jh\Logger\Api\IssueRepositoryInterface;
use Jh\Logger\Api\ReportManagementInterface;
use Jh\Logger\Model\AlertFactory;
use Jh\Logger\Model\IssueFactory;
use Jh\Logger\Model\ResourceModel\Issue as IssueResource;
use Jh\Logger\Model\ResourceModel\Issue\CollectionFactory;

class IssueManagement implements IssueManagementInterface
{
    private $issueRepository;
    private $issueFactory;
    private $searchCriteriaBuilder;
    private $collectionFactory;
    private $issueResource;
    private $alertFactory;
    private $mailService;
    private $reportManagement;

    public function __construct(
        IssueRepositoryInterface $issueRepository,
        IssueFactory $issueFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CollectionFactory $collectionFactory,
        IssueResource $issueResource,
        AlertFactory $alertFactory,
        MailService $mailService,
        ReportManagementInterface $reportManagement
    ) {
        $this->issueRepository       = $issueRepository;
        $this->issueFactory          = $issueFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionFactory     = $collectionFactory;
        $this->issueResource         = $issueResource;
        $this->alertFactory          = $alertFactory;
        $this->mailService           = $mailService;
        $this->reportManagement      = $reportManagement;
    }

    /**
     * @inheritDoc
     */
    public function isOpen(string $type): int
    {
        try {
            $issueId = $this->issueResource->loadActive($type);
            return $issueId;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function open(string $type): int
    {
        $issue = $this->issueFactory->create();
        $issue->setId(null);
        $issue->setType($type);
        $issue->setIsActive(true);
        $newIssue = $this->issueRepository->save($issue);
        return $newIssue->getId();
    }

    /**
     * @inheritDoc
     */
    public function clean(\DateTime $cleanDate)
    {
        $this->issueResource->cleanupOldData($cleanDate);
    }
}
