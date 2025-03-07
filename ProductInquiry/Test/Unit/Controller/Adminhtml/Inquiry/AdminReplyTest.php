<?php
namespace Vendor\ProductInquiry\Test\Unit\Controller\Adminhtml\Inquiry;

use PHPUnit\Framework\TestCase;
use Vendor\ProductInquiry\Controller\Adminhtml\Inquiry\SendResponse;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Vendor\ProductInquiry\Model\InquiryFactory;
use Vendor\ProductInquiry\Model\Inquiry;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;

class AdminReplyTest extends TestCase
{
    
    /** @var SendResponse */
    private $sendResponseController;

    /** @var Context|\PHPUnit\Framework\MockObject\MockObject */
    private $contextMock;

    /** @var InquiryFactory|\PHPUnit\Framework\MockObject\MockObject */
    private $inquiryFactoryMock;

    /** @var TransportBuilder|\PHPUnit\Framework\MockObject\MockObject */
    private $transportBuilderMock;

    /** @var StoreManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $storeManagerMock;

    /** @var JsonFactory|\PHPUnit\Framework\MockObject\MockObject */
    private $jsonFactoryMock;

    /** @var RequestInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $requestMock;

    /** @var Inquiry|\PHPUnit\Framework\MockObject\MockObject */
    private $inquiryMock;

    /** @var ManagerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $messageManagerMock;

    /** @var RedirectFactory|\PHPUnit\Framework\MockObject\MockObject */
    private $resultRedirectFactoryMock;

    /** @var Redirect|\PHPUnit\Framework\MockObject\MockObject */
    private $redirectMock;

    /** @var TransportInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $transportMock;
    
    protected function setUp(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->inquiryFactoryMock = $this->createMock(InquiryFactory::class);
        $this->transportBuilderMock = $this->createMock(TransportBuilder::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->jsonFactoryMock = $this->createMock(JsonFactory::class);
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->messageManagerMock = $this->createMock(ManagerInterface::class);
        $this->resultRedirectFactoryMock = $this->createMock(RedirectFactory::class);
        $this->redirectMock = $this->createMock(Redirect::class);
        $this->transportMock = $this->createMock(TransportInterface::class);
    
        $this->inquiryMock = $this->createMock(Inquiry::class);


    // ✅ Create Inquiry Mock
        $this->inquiryMock = $this->createMock(\Vendor\ProductInquiry\Model\Inquiry::class);

    // ✅ Ensure InquiryFactory Returns Inquiry Mock
        $this->inquiryFactoryMock->method('create')->willReturn($this->inquiryMock);
    
        // ✅ Ensure Context Mock Returns Message Manager
        $this->contextMock->method('getMessageManager')->willReturn($this->messageManagerMock);
    
        // ✅ Pass Message Manager When Instantiating Controller
        $this->sendResponseController = new SendResponse(
            $this->contextMock,
            $this->inquiryFactoryMock,
            $this->transportBuilderMock,
            $this->storeManagerMock,
            $this->jsonFactoryMock,
            $this->messageManagerMock
        );
    }
    


    public function testAdminReply()
    {
        $data = [
            'inquiry_id' => 1,
            'send_message' => 'Thank you for your inquiry. We will get back to you soon.'
        ];
    
        $this->requestMock->method('getParam')
            ->willReturnCallback(fn($key) => $data[$key] ?? null);
    
        // ✅ Ensure Inquiry Mock Loads Correctly
        $this->inquiryMock->method('load')->willReturnSelf();
        $this->inquiryMock->method('getId')->willReturn(1); // ✅ Use getId() instead of getInquiryId()
        $this->inquiryMock->method('getCustomerEmail')->willReturn('customer@example.com');
        $this->inquiryMock->method('getCustomerName')->willReturn('John Doe');
    
        $result = $this->sendResponseController->execute();
    
        $this->assertInstanceOf(\Magento\Framework\Controller\Result\Redirect::class, $result);
    }
}
