<?php

namespace Vendor\ProductInquiry\Controller\Adminhtml\Inquiry;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Vendor\ProductInquiry\Model\InquiryFactory;
use Magento\Framework\Message\ManagerInterface; // ✅ Add This
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class SendResponse
 * Handles sending a response email to the customer for a product inquiry.
 */

class SendResponse extends Action
{
   
    /**
     * @var InquiryFactory
     */
    protected $inquiryFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * SendResponse constructor.
     *
     * @param Context $context
     * @param InquiryFactory $inquiryFactory
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param JsonFactory $jsonFactory
     * @param ManagerInterface $messageManager
     */

    public function __construct(
        Context $context,
        InquiryFactory $inquiryFactory,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        JsonFactory $jsonFactory,
        ManagerInterface $messageManager // ✅ Inject Here
    ) {
        parent::__construct($context);
        $this->inquiryFactory = $inquiryFactory;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->jsonFactory = $jsonFactory;
        $this->messageManager = $messageManager; // ✅ Assign It
    }

    /**
     * Execute method to send a response email.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $inquiryId = $this->getRequest()->getParam('inquiry_id');
        $message = $this->getRequest()->getParam('send_message');

        if (!$inquiryId) {
            $this->messageManager->addErrorMessage(__('Invalid request. Inquiry ID is missing.'));
            return $resultRedirect->setPath('*/*/');
        }

        $inquiry = $this->inquiryFactory->create()->load($inquiryId);
        if (!$inquiry->getId()) {
            $this->messageManager->addErrorMessage(__('Inquiry not found.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $customerEmail = $inquiry->getCustomerEmail();
            $customerName = $inquiry->getCustomerName();
     
            $transport = $this->transportBuilder
            ->setTemplateIdentifier('product_inquiry_email_template')
            ->setTemplateOptions([
                'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                'store' => $this->storeManager->getStore()->getId(),
            ])
                ->setTemplateVars([
                'customer_name' => !empty($customerName) ? (string) $customerName : 'Valued Customer',
                'response_message' => !empty($message) ? (string) $message : 'Thank you for reaching out to us.',
            ])
                ->setFrom(['email' => 'support@yourstore.com', 'name' => 'Support Team'])
                ->addTo($customerEmail, $customerName)
                ->getTransport();

            $transport->sendMessage();

            $this->messageManager->addSuccessMessage(__('Email sent successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error sending email: ') . $e->getMessage());
        }

    // Redirect back to the grid page
        return $resultRedirect->setPath('*/*/');
    }
}
