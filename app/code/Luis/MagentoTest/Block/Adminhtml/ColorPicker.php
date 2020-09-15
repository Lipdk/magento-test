<?php

namespace Luis\MagentoTest\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

class ColorPicker extends Field
{
    /**
     * @param  AbstractElement $element
     * @return string script
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $value = $element->getData('value');

        $additionalHtml = <<<HTML
<script type="text/javascript">
require(["jquery"], function ($) {
    $(document).ready(function (e) {
        $('#{$element->getHtmlId()}').css('background-color', '#{$value}');
        $('#{$element->getHtmlId()}').colpick({
            layout: 'hex',
            submit: 0,
            colorScheme: 'dark',
            color: '#{$value}',
            onChange: function(hsb, hex, rgb, el, bySetColor) {
                $(el).css('background-color', '#' + hex);
                if(!bySetColor) $(el).val(hex);
            }
        }).keyup(function(){
            $(this).colpickSetColor(this.value);
        });
    });
});
</script>
HTML;

        return $element->getElementHtml() . $additionalHtml;
    }
}
