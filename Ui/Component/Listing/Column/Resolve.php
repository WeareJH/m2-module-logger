<?php

declare(strict_types=1);

namespace Jh\Logger\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Resolve extends Column
{
    const URL_PATH_RESOLVE = 'logger/issue/resolve';

    private $url;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $url,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->url = $url;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item['is_active'] === 'Active') {
                    $item[$this->getData('name')]['resolve'] = [
                        'href' => $this->url->getUrl(self::URL_PATH_RESOLVE, ['issue_id' => $item['issue_id']]),
                        'label' => __('Resolve'),
                        'confirm' => [
                            'title' => __('Resolve issue'),
                            'message' => __('Are you sure you want to resolve this issue?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
