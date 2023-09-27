<?php
declare(strict_types=1);

namespace ExpandingWeb\OpenAi\Model;

use Magento\Framework\Model\AbstractModel;
use ExpandingWeb\OpenAi\Api\Data\ExpandingWebOpenAiLogInterface;
use ExpandingWeb\OpenAi\Model\ResourceModel\ExpandingWebOpenAiLog as ResourceModel;

class ExpandingWebOpenAiLog extends AbstractModel implements ExpandingWebOpenAiLogInterface
{
    /**
     * Initialize magento model.
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return (int)$this->_getData(ExpandingWebOpenAiLogInterface::ID);
    }

    /**
     * @inheritdoc
     */
    public function getRequest(): string
    {
        return $this->_getData(ExpandingWebOpenAiLogInterface::REQUEST);
    }

    /**
     * @inheritdoc
     */
    public function setRequest(string $value): ExpandingWebOpenAiLogInterface
    {
        $this->setData(ExpandingWebOpenAiLogInterface::REQUEST, $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getResponse(): string
    {
        return $this->_getData(ExpandingWebOpenAiLogInterface::RESPONSE);
    }

    /**
     * @inheritdoc
     */
    public function setResponse(string $value): ExpandingWebOpenAiLogInterface
    {
        $this->setData(ExpandingWebOpenAiLogInterface::RESPONSE, $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt(): string
    {
        return $this->_getData(ExpandingWebOpenAiLogInterface::CREATED_AT);
    }
}
