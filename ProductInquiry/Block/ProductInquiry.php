<?php

namespace Vendor\ProductInquiry\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Product;

/**
 * Class ProductInquiry
 * Block class for handling product inquiries on the product detail page.
 */


class ProductInquiry extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * ProductInquiry constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }
    /**
     * Retrieve the current product
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
}
