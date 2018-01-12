<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * View Column
 */
class ViewAction extends Column
{
    /**
     * Url Builder
     * 
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Initialize Column
     * 
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        
        parent::__construct(
			$context, 
			$uiComponentFactory, 
			$components, 
			$data
		);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['log_id'])) {
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'log_id';
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->_urlBuilder->getUrl(
                                $viewUrlPath,
                                [
                                    $urlEntityParamName => $item['log_id']
                                ]
                            ),
                            'label' => __('View')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}