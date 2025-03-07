<?php

namespace Vendor\ProductInquiry\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Vendor\ProductInquiry\Helper\EmailHelper;
use Psr\Log\LoggerInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Vendor\ProductInquiry\Model\InquiryFactory;

/**
 * Class Index
 * Handles product inquiry form submission.
 */

class Index extends Action
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var EmailHelper
     */
    protected $emailHelper;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @var InquiryFactory
     */
    protected $inquiryFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param ManagerInterface $messageManager
     * @param Validator $formKeyValidator
     * @param EmailHelper $emailHelper
     * @param LoggerInterface $logger
     * @param RedirectFactory $redirectFactory
     * @param InquiryFactory $inquiryFactory
     */

    public function __construct(
        Context $context,
        ManagerInterface $messageManager,
        Validator $formKeyValidator,
        EmailHelper $emailHelper,
        LoggerInterface $logger,
        RedirectFactory $redirectFactory,
        InquiryFactory $inquiryFactory
    ) {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->emailHelper = $emailHelper;
        $this->logger = $logger;
        $this->redirectFactory = $redirectFactory;
        $this->inquiryFactory = $inquiryFactory;
    }

    /**
     * Handles form submission, saves inquiry, and sends email.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $request = $this->getRequest();
        
        // Validate form key for security
        if (!$this->formKeyValidator->validate($request)) {
            $this->messageManager->addErrorMessage(__('Invalid form submission.'));
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        }

        $data = $request->getPostValue();

        if (!$data) {
            $this->messageManager->addErrorMessage(__('Invalid form submission.'));
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
        }

        try {
            // Save the inquiry to the database
            $inquiry = $this->inquiryFactory->create();
            $inquiry->setData($data);
            $inquiry->save();

            // Send admin notification using email template
            $this->emailHelper->sendAdminNotification($data);

            $this->messageManager->addSuccessMessage(__('Your inquiry has been submitted successfully.'));
        } catch (\Exception $e) {
            $this->logger->error('Product Inquiry Error: ' . $e->getMessage());
            $this->messageManager->addErrorMessage(__('There was an error submitting your inquiry.'));
        }

        return $this->resultRedirectFactory->create()->setUrl($this->_redirect->getRefererUrl());
    }
}
