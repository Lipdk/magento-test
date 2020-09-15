<?php

namespace Luis\MagentoTest\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface as StoreScopeInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class ConfigHelper
{
    public const PRIMARY_BG_COLOR = 'web/design/primary_bg_color';
    public const PRIMARY_TEXT_COLOR = 'web/design/primary_text_color';

    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /** @var WriterInterface */
    protected $configWriter;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param WriterInterface $configWriter
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
    }

    /**
     * @param string $key
     * @param string $scopeType
     * @return mixed
     */
    protected function getBackendSetting($key, $scopeType = StoreScopeInterface::SCOPE_STORE)
    {
        return $this->scopeConfig->getValue($key, StoreScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string|null
     */
    public function getPrimaryBgColor() : ?string
    {
        return $this->getBackendSetting(self::PRIMARY_BG_COLOR, StoreScopeInterface::SCOPE_STORE);
    }

    /**
     * @param string $value
     * @param int $storeId
     */
    public function setPrimaryBgColor($value, $storeId)
    {
        $this->configWriter->save(self::PRIMARY_BG_COLOR, $value, StoreScopeInterface::SCOPE_STORES, $storeId);
    }

    /**
     * @return string|null
     */
    public function getPrimaryTextColor() : ?string
    {
        return $this->getBackendSetting(self::PRIMARY_TEXT_COLOR, StoreScopeInterface::SCOPE_STORE);
    }

    /**
     * @param string $value
     * @param int $storeId
     */
    public function setPrimaryTextColor($value, $storeId)
    {
        $this->configWriter->save(self::PRIMARY_TEXT_COLOR, $value, StoreScopeInterface::SCOPE_STORES, $storeId);
    }
}
