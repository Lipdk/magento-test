<?php

namespace Luis\MagentoTest\Block\Cms;

use Magento\Cms\Model\Page;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface as StoreScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class HeadHrefLang extends Template
{
    /** @var Page */
    protected $page;

    /** @var StoreManagerInterface */
    protected $storeManager;

    /**
     * @param Context $context
     * @param Page $page
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        Page $page,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->page = $page;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @return Page
     */
    public function getCmsPage()
    {
        return $this->page;
    }

    /**
     * @return StoreInterface[]
     */
    public function getStoresAvailability()
    {
        if (!$this->page || empty($this->page->getId())) {
            return [];
        }

        $pageStores = $this->page->getStores();
        $availableStores = [];

        if (!empty($pageStores)) {
            foreach ($this->storeManager->getStores() as $store) {
                // Note: when the CMS is available for all store views $pageStores[0] == '0' is evaluate to true
                if (in_array($store->getId(), $pageStores) || $pageStores[0] == '0') {
                    $store->setData(
                        'domain',
                        $this->_scopeConfig->getValue('web/unsecure/base_url', StoreScopeInterface::SCOPE_STORE, $store)
                    );
                    $availableStores[] = $store;
                }
            }
        }

        return $availableStores;
    }
}
