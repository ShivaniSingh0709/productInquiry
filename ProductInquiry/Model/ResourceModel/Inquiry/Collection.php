<?php
namespace Vendor\ProductInquiry\Model\ResourceModel\Inquiry;

/**
 * Class Collection
 * Represents the collection of Product Inquiry records.
 */

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
     /**
     * @var string Primary key field name
     */
    protected $_idFieldName = 'inquiry_id';

    /**
     * @var string Event prefix for collection events
     */
    protected $_eventPrefix = 'product_inquiry_collection';

    /**
     * @var string Event object for collection events
     */
    protected $_eventObject = 'product_inquiry_collection';

    /**
     * Define resource model
     *
     * @return void
     */

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Vendor\ProductInquiry\Model\Inquiry', 'Vendor\ProductInquiry\Model\ResourceModel\Inquiry');
    }
}
