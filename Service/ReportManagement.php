<?php

namespace Jh\Logger\Service;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Jh\Logger\Api\Data\LogInterface;
use Jh\Logger\Api\IssueRepositoryInterface;
use Jh\Logger\Api\LogRepositoryInterface;
use Jh\Logger\Api\ReportManagementInterface;
use Jh\Logger\Model\AlertFactory;

class ReportManagement implements ReportManagementInterface
{
    private $mailService;
    private $alertFactory;
    private $searchCriteriaBuilder;
    private $issueRepository;
    private $logRepository;

    public function __construct(
        MailService $mailService,
        AlertFactory $alertFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        IssueRepositoryInterface $issueRepository,
        LogRepositoryInterface $logRepository
    ) {
        $this->mailService           = $mailService;
        $this->alertFactory          = $alertFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->issueRepository       = $issueRepository;
        $this->logRepository         = $logRepository;
    }

    public function sendReport(int $id, string $type)
    {
        $report  = $this->getReport($id);
        $subject = sprintf('Issue Closed: %s', $type);
        $alert   = $this->alertFactory->create();
        $alert->setException(null);
        $alert->setMessage($report);
        $alert->setSubject($subject);
        $this->mailService->sendMail($alert);
    }

    private function getReport(int $id): string
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('issue_id', $id)->create();
        $searchCriteria = $this->logRepository->getList($searchCriteria);
        $message        = implode("\n", \array_map(function (LogInterface $value) {
            return $value->getMessage();
        }, $searchCriteria->getItems()));
        return $message;
    }
}
