<?php
declare(strict_types=1);

namespace ExpandingWeb\OpenAi\Test\Unit\Controller\Adminhtml\Api;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use ExpandingWeb\OpenAi\Controller\Adminhtml\Api\GetResponse;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use ExpandingWeb\OpenAi\Helper\Data as HelperData;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;

class GetResponseTest extends TestCase
{
    /**
     * @var GetResponse
     */
    protected $controller;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HelperData
     */
    protected $helperData;

    /**
     * @var Json
     */
    protected $resultJson;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * Set up
     *
     * @return void
     */
    protected function setUp(): void
    {
        $context = $this->createMock(Context::class);
        $this->request = $this->getMockBuilder(RequestInterface::class)
            ->getMockForAbstractClass();
        $context->method('getRequest')
            ->willReturn($this->request);

        $this->helperData = $this->createPartialMock(
            HelperData::class,
            ['getPrefixQuestion', 'getAnswer']
        );

        $this->resultJson = $this->getMockBuilder(Json::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->jsonFactory = $this->getMockBuilder(JsonFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $objectManager = new ObjectManager($this);
        $this->controller = $objectManager->getObject(
            GetResponse::class,
            [
                'context' => $context,
                'helperData' => $this->helperData,
                'jsonFactory' => $this->jsonFactory
            ]
        );
    }

    /**
     * Test Execute
     *
     * @return void
     */
    public function testExecute(): void
    {
        $this->controller->execute();
    }
}
