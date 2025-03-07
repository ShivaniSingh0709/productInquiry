<?php

namespace Vendor\ProductInquiry\Model\ResourceModel;

/**
 * Class Inquiry
 * Resource model for the Product Inquiry entity.
 */

class Inquiry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Inquiry constructor.
     *
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }
    /**
     * Initialize the resource model
     */
    protected function _construct()
    {
        $this->_init('product_inquiry', 'inquiry_id');
    }
}
