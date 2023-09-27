<?php
namespace ExpandingWeb\OpenAi\Controller\Adminhtml\Api;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use ExpandingWeb\OpenAi\Helper\Data as HelperData;
use Magento\Framework\Controller\Result\JsonFactory;

class GetResponse extends Action implements HttpPostActionInterface
{
    /**
     * @var HelperData
     */
    protected $helperData;

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param HelperData $helperData
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        HelperData $helperData,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->helperData = $helperData;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Get answer from AI
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $success = true;
        $question = $this->getQuestion();
        if ($question) {
            $answer = $this->helperData->getAnswer($question);
            if (!empty($answer)) {
                $answer = trim($answer);
            }
        } else {
            $success = false;
            $answer = __('Please add context so the AI can come up with the right content.');
        }

        return $resultJson->setData([
            'answer' => $answer,
            'success' => $success
        ]);
    }

    /**
     * Get Question
     *
     * @return string||null
     */
    private function getQuestion()
    {
        $question = null;
        $name = $this->getRequest()->getParam('name');
        $fieldIndex = $this->getRequest()->getParam('field_index');
        $prefixQuestion = $this->helperData->getPrefixQuestion($fieldIndex);
        $type = $this->getRequest()->getParam('type');
        $keywordsExtra = $this->getRequest()->getParam('keywords_extra');
        if ($name && $prefixQuestion) {
            $question = __($prefixQuestion) . ' ' . __($type) . ' ' . $name;
            if ($keywordsExtra) {
                $question .=  ' ' . __('including this text') . ': ' . $keywordsExtra;
            }
        } elseif ($fieldIndex == 'content_from_ai') {
            if ($keywordsExtra) {
                $question = $keywordsExtra;
            } else {
                return null;
            }
        }

        return $question;
    }
}
