<?php

declare(strict_types=1);

namespace Jh\Logger\Controller\Adminhtml\Issue;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Jh\Logger\Model\IssueFactory;
use Jh\Logger\Model\ResourceModel\Issue as IssueResource;

class Resolve extends Action
{
    private $issueFactory;
    private $issueResource;

    public function __construct(Context $context, IssueFactory $issueFactory, IssueResource $issueResource)
    {
        parent::__construct($context);
        $this->issueFactory = $issueFactory;
        $this->issueResource = $issueResource;
    }

    public function execute()
    {
        $issueId = (int) $this->getRequest()->getParam('issue_id');

        $issue = $this->issueFactory->create();
        $this->issueResource->load($issue, $issueId);
        $issue->setData('is_active', 0);
        $this->issueResource->save($issue);

        $this->messageManager->addSuccessMessage('Successfully resolved issue.');
        return $this->_redirect('*/*');
    }
}
