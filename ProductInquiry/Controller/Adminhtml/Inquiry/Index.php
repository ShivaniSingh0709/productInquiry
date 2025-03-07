<?php

namespace Vendor\ProductInquiry\Controller\Adminhtml\Inquiry;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * Handles displaying the Product Inquiry grid in the admin panel.
 */

class Index extends Action
{
   /**
    * 
    * @var PageFactory
    */
    
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute method to render the product inquiries grid.
     *
     * @return \Magento\Framework\View\Result\Page
     */

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Vendor_ProductInquiry::product_inquiry');
        $resultPage->getConfig()->getTitle()->prepend(__('Product Inquiries'));

        return $resultPage;
    }
}
