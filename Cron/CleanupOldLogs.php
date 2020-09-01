<?php


namespace Jh\Logger\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Jh\Logger\Api\IssueManagementInterface;
use Jh\Logger\Api\LoggerManagementInterface;

class CleanupOldLogs
{
    const DEFAULT_CLEAN_DAYS       = 30;
    const XML_PATH_CLEANUP_DAYS    = 'jh_logger/clean/days';
    const XML_PATH_CLEANUP_ENABLED = 'jh_logger/clean/enabled';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var IssueManagementInterface
     */
    private $issueManagement;
    /**
     * @var LoggerManagementInterface
     */
    private $loggerManagement;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        IssueManagementInterface $issueManagement,
        LoggerManagementInterface $loggerManagement
    ) {
        $this->scopeConfig      = $scopeConfig;
        $this->issueManagement  = $issueManagement;
        $this->loggerManagement = $loggerManagement;
    }

    /**
     * @return string
     */
    public function getConfigDays(): string
    {
        $configDays = $this->scopeConfig->getValue(self::XML_PATH_CLEANUP_DAYS);
        return $configDays ? $configDays : self::DEFAULT_CLEAN_DAYS;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::XML_PATH_CLEANUP_ENABLED);
    }

    public function execute()
    {
        if (!$this->isEnabled()) {
            return;
        }
        $cleanDate = new \DateTime();
        $daysAgo   = sprintf('-%d days', $this->getConfigDays());
        $cleanDate->modify($daysAgo);
        $this->issueManagement->clean($cleanDate);
        $this->loggerManagement->clean($cleanDate);
        return;
    }
}
