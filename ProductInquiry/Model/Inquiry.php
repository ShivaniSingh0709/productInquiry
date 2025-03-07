<?php

namespace Vendor\ProductInquiry\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Inquiry
 * Represents the Product Inquiry model.
 */
class Inquiry extends AbstractModel implements IdentityInterface
{
    /**
     * Cache tag for Product Inquiry
     */
    public const CACHE_TAG = 'product_inquiry';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'product_inquiry';

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(\Vendor\ProductInquiry\Model\ResourceModel\Inquiry::class);
    }

    /**
     * Retrieve unique identities for caching
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        return [];
    }
}
