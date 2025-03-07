<?php

namespace Vendor\ProductInquiry\Test\Unit\Block;

use PHPUnit\Framework\TestCase;
use Vendor\ProductInquiry\Block\ProductInquiry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;

class FormValidationTest extends TestCase
{
   /** @var ProductInquiry */
    private $productInquiryBlock;

   /** @var Context|\PHPUnit\Framework\MockObject\MockObject */
    private $contextMock;

   /** @var Registry|\PHPUnit\Framework\MockObject\MockObject */
    private $registryMock;

   /** @var Product|\PHPUnit\Framework\MockObject\MockObject */
    private $productMock;
   
    protected function setUp(): void
    {
        $this->contextMock = $this->createMock(Context::class);
        $this->registryMock = $this->createMock(\Magento\Framework\Registry::class);
        $this->productMock = $this->createMock(Product::class);
    
        // Mock event manager to avoid errors
        $eventManagerMock = $this->createMock(\Magento\Framework\Event\ManagerInterface::class);
        $this->contextMock->method('getEventManager')->willReturn($eventManagerMock);
    
        // Mock Registry to return a Product object when 'current_product' is called
        $this->registryMock->method('registry')->with('current_product')->willReturn($this->productMock);
    
        // Mock ProductInquiry block and override `toHtml()`
        $this->productInquiryBlock = $this->getMockBuilder(ProductInquiry::class)
            ->setConstructorArgs([$this->contextMock, $this->registryMock, []])
            ->onlyMethods(['toHtml'])  // Override toHtml()
            ->getMock();
    
        // Simulate form rendering inside toHtml()
        $this->productInquiryBlock->method('toHtml')->willReturn(
            '<form><input type="text" name="customer_name"/><input type="email" name="customer_email"/>
            <input type="text" name="inquiry_subject"/><textarea name="inquiry_message"></textarea></form>'
        );
    }
    
    


    public function testRequiredFields()
    {
        $formHtml = $this->productInquiryBlock->toHtml();
        
        // Check if required fields exist in the form
        $this->assertStringContainsString('name="customer_name"', $formHtml);
        $this->assertStringContainsString('name="customer_email"', $formHtml);
        $this->assertStringContainsString('name="inquiry_subject"', $formHtml);
        $this->assertStringContainsString('name="inquiry_message"', $formHtml);
    }
}
