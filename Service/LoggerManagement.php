<?php

namespace Jh\Logger\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Jh\Logger\Api\Data\LogInterfaceFactory;
use Jh\Logger\Api\IssueManagementInterface;
use Jh\Logger\Api\IssueRepositoryInterface;
use Jh\Logger\Api\LoggerManagementInterface;
use Jh\Logger\Api\LogRepositoryInterface;
use Jh\Logger\Api\ReportManagementInterface;
use Jh\Logger\Model\AlertFactory;
use Jh\Logger\Model\ResourceModel\Log as LogResource;
use Jh\Logger\Model\ResourceModel\Log\CollectionFactory;

class LoggerManagement implements LoggerManagementInterface
{
    const XML_PATH_JH_LOGGER_SUBJECT_PREFIX = 'jh_logger/alert/subject_prefix';
    const XML_PATH_JH_LOGGER_EMAIL_ENABLED  = 'jh_logger/alert/email_enabled';

    private $logFactory;
    private $logRepository;
    private $issueManagement;
    private $collectionFactory;
    private $logResource;
    private $alertFactory;
    private $scopeConfig;
    private $mailService;
    /**
     * @var IssueRepositoryInterface
     */
    private $issueRepository;
    /**
     * @var ReportManagementInterface
     */
    private $reportManagement;

    public function __construct(
        LogInterfaceFactory $logFactory,
        LogRepositoryInterface $logRepository,
        IssueRepositoryInterface $issueRepository,
        ReportManagementInterface $reportManagement,
        IssueManagementInterface $issueManagement,
        CollectionFactory $collectionFactory,
        LogResource $logResource,
        ScopeConfigInterface $scopeConfig,
        AlertFactory $alertFactory,
        MailService $mailService
    ) {
        $this->logFactory        = $logFactory;
        $this->logRepository     = $logRepository;
        $this->issueManagement   = $issueManagement;
        $this->collectionFactory = $collectionFactory;
        $this->logResource = $logResource;
        $this->alertFactory      = $alertFactory;
        $this->scopeConfig       = $scopeConfig;
        $this->mailService       = $mailService;
        $this->issueRepository = $issueRepository;
        $this->reportManagement = $reportManagement;
    }

    /**
     * @inheritDoc
     */
    public function addEvent(
        string $type,
        string $message = '',
        string $identifierLabel = '',
        string $identifierValue = '',
        int $severity = 1,
        bool $createIssue = true,
        \Exception $exception = null
    ): bool {
        $issueId = 0;
        if ($createIssue === true) {
            $issueId = $this->createIssue($type, $message, $exception);
        }
        $log = $this->logFactory->create();
        $log->setLoggerId(null);
        $log->setIssueId($issueId);
        $log->setType($type);
        $log->setMessage($message);
        $log->setSeverity($severity);
        $log->setIdentifierLabel($identifierLabel);
        $log->setIdentifierValue($identifierValue);
        $this->logRepository->save($log);
        return true;
    }

    private function sendAlert(string $type, string $message, ?\Exception $exception)
    {
        $subject = sprintf(
            '%s: %s',
            $this->scopeConfig->getValue(self::XML_PATH_JH_LOGGER_SUBJECT_PREFIX),
            $type
        );
        if ($exception instanceof \Exception) {
            $message .= sprintf("\n\n %s", $exception->getMessage());
        }

        $alert   = $this->alertFactory->create();
        $alert->setException($exception);
        $alert->setMessage($message);
        $alert->setSubject($subject);
        $this->mailService->sendMail($alert);
    }

    /**
     * @param string $type
     * @param string $message
     * @param \Exception|null $exception
     * @return bool|int
     * @throws \Exception
     */
    private function createIssue(string $type, string $message, \Exception $exception = null)
    {
        if ($issueId = $this->issueManagement->isOpen($type)) {
            return $issueId;
        }

        if ($this->scopeConfig->getValue(self::XML_PATH_JH_LOGGER_EMAIL_ENABLED)) {
            $this->sendAlert($type, $message, $exception);
        }

        return $this->issueManagement->open($type);
    }


    /**
     * @inheritDoc
     */
    public function clean(\DateTime $cleanDate)
    {
        $this->logResource->cleanupOldData($cleanDate);
    }

    /**
     * @inheritDoc
     */
    public function closeIssue(string $type): bool
    {
        try {
            $issue = $this->issueRepository->get($type);
            $issue->setIsActive(false);
            $this->reportManagement->sendReport($issue->getId(), $issue->getType());
            $this->issueRepository->save($issue);
        } catch (NoSuchEntityException $e) {
            return false;
        }
        return true;
    }
}
