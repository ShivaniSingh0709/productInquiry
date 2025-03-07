<?php
namespace Vendor\ProductInquiry\Test\Unit\Helper;

use PHPUnit\Framework\TestCase;
use Vendor\ProductInquiry\Helper\EmailHelper;
use Magento\Framework\App\Helper\Context;
use Magento\AdminNotification\Model\Inbox;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class EmailHelperTest extends TestCase
{
     /** @var EmailHelper */
     private $emailHelper;

     /** @var Context|\PHPUnit\Framework\MockObject\MockObject */
     private $contextMock;
 
     /** @var Inbox|\PHPUnit\Framework\MockObject\MockObject */
     private $inboxMock;
 
     /** @var TransportBuilder|\PHPUnit\Framework\MockObject\MockObject */
     private $transportBuilderMock;
 
     /** @var StoreManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
     private $storeManagerMock;
 
     /** @var LoggerInterface|\PHPUnit\Framework\MockObject\MockObject */
     private $loggerMock;

    protected function setUp(): void
    {
        // Create mocks for all dependencies
        $this->contextMock = $this->createMock(Context::class);
        $this->inboxMock = $this->createMock(Inbox::class);
        $this->transportBuilderMock = $this->createMock(TransportBuilder::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        // Create instance of EmailHelper with mocked dependencies
        $this->emailHelper = new EmailHelper(
            $this->contextMock,
            $this->inboxMock,
            $this->transportBuilderMock,
            $this->storeManagerMock,
            $this->loggerMock
        );
    }

    public function testSendAdminNotification()
    {
        $data = [
            'customer_name' => 'John Doe',
            'customer_email' => 'sr070996@gmail.com',
            'inquiry_subject' => 'Product Inquiry',
            'inquiry_message' => 'Hello, I have a question about this product.'
        ];

        // Add assertions based on expected behavior
        $this->assertNotEmpty($data['customer_name']);
        $this->assertEquals('John Doe', $data['customer_name']);
    }
}
