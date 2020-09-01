<?php

namespace Jh\Logger\Service;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Jh\Logger\Model\Alert;

class MailService
{
    const XML_PATH_JH_LOGGER_ALERT_DEFAULT_NAME  = 'jh_logger/alert/default_name';
    const XML_PATH_JH_LOGGER_ALERT_DEFAULT_EMAIL = 'jh_logger/alert/default_email';

    private $transportBuilder;
    private $scopeConfig;
    private $storeManager;
    private $urlBuilder;
    private $logger;

    public function __construct(
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        LoggerInterface $logger
    ) {
        $this->transportBuilder   = $transportBuilder;
        $this->scopeConfig        = $scopeConfig;
        $this->storeManager       = $storeManager;
        $this->urlBuilder         = $urlBuilder;
        $this->logger             = $logger;
    }

    public function sendMail(Alert $alert)
    {
        $template = 'jh_logger_alert';
        $to[]     = $this->scopeConfig->getValue(self::XML_PATH_JH_LOGGER_ALERT_DEFAULT_EMAIL) ?? '';

        $message = $alert->getMessage();

        $transport = $this->getMail(
            $template,
            $to,
            [
                'subject' => $alert->getSubject(),
                'message' => $message
            ]
        );

        try {
            $transport->sendMessage();
        } catch (MailException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    private function getMail(string $template, array $addresses, array $params)
    {
        $defaultName = $this->scopeConfig->getValue(self::XML_PATH_JH_LOGGER_ALERT_DEFAULT_NAME) ?? '';
        $defaultEmail = $this->scopeConfig->getValue(self::XML_PATH_JH_LOGGER_ALERT_DEFAULT_EMAIL) ?? '';
        $addresses[] = $defaultEmail;
        $transport = $this->transportBuilder
            ->addTo($addresses, $defaultName)
            ->setFromByScope(['email' => $defaultEmail, 'name' => $defaultName])
            ->setTemplateIdentifier($template)
            ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
            ->setTemplateVars($params)
            ->getTransport();

        return $transport;
    }
}
