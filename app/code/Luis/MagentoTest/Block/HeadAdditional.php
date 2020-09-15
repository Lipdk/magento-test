<?php

namespace Luis\MagentoTest\Block;

use Luis\MagentoTest\Helper\ConfigHelper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class HeadAdditional extends Template
{
    /** @var ConfigHelper */
    protected $configHelper;

    /**
     * @param Context $context
     * @param ConfigHelper $configHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigHelper $configHelper,
        array $data = []
    ) {
        $this->configHelper = $configHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return string|null
     */
    public function getPrimaryBgColor() : ?string
    {
        return $this->configHelper->getPrimaryBgColor();
    }

    /**
     * @return string|null
     */
    public function getPrimaryTextColor() : ?string
    {
        return $this->configHelper->getPrimaryTextColor();
    }
}
