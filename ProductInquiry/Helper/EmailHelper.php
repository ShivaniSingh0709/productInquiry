<?php

namespace Vendor\ProductInquiry\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\AdminNotification\Model\Inbox;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class EmailHelper
 * Handles email notifications for product inquiries.
 */
class EmailHelper extends AbstractHelper
{
    /**
     * @var Inbox
     */
    protected $inbox;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * EmailHelper constructor.
     *
     * @param Context $context
     * @param Inbox $inbox
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Inbox $inbox,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->inbox = $inbox;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * Send Admin Notification using Email Template.
     *
     * @param array $data
     * @return void
     */
    public function sendAdminNotification($data)
    {
        try {
            $store = $this->storeManager->getStore();
            $templateVars = [
                'customer_name'   => isset($data['customer_name']) ? (string) $data['customer_name'] : '',
                'customer_email'  => isset($data['customer_email']) ? (string) $data['customer_email'] : '',
                'inquiry_subject' => isset($data['inquiry_subject']) ? (string) $data['inquiry_subject'] : '',
                'inquiry_message' => isset($data['inquiry_message']) ? (string) $data['inquiry_message'] : '',
                'store_name'      => $store->getName() ? (string) $store->getName() : ''
            ];

            // Render the email template
            // $transport = $this->transportBuilder
            //     ->setTemplateIdentifier('product_inquiry_email_template') // Email template ID
            //     ->setTemplateOptions([
            //         'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
            //         'store' => $store->getId(),
            //     ])
            //     ->setTemplateVars($templateVars)
            //     ->setFromByScope('general') // Use Magento's general email settings
            //     ->addTo('abc@gmail.com') // Admin Email (placeholder)
            //     ->getTransport();

            // Send email
            // $transport->sendMessage();
            $adminMessage = sprintf(
                "New Product Inquiry:\n\nName: %s\nEmail: %s\nSubject: %s\nProduct SKU: %s\nMessage: %s",
                $data['customer_name'] ?? '',
                $data['customer_email'] ?? '',
                $data['inquiry_subject'] ?? '',
                $data['sku'] ?? 'N/A',
                $data['inquiry_message'] ?? ''
            );

            // Add Admin Notification
            $this->inbox->addNotice(
                __('New Product Inquiry'),
                __($adminMessage),
                ''
            );
        } catch (\Exception $e) {
            $this->logger->error('Admin Notification Error: ' . $e->getMessage());
        }
    }
}
