<?php
declare(strict_types=1);

namespace ExpandingWeb\OpenAi\Model;

use ExpandingWeb\OpenAi\Api\Data\ExpandingWebOpenAiLogInterface;
use ExpandingWeb\OpenAi\Api\Data\ExpandingWebOpenAiLogInterfaceFactory;
use ExpandingWeb\OpenAi\Api\ExpandingWebOpenAiLogRepositoryInterface;
use ExpandingWeb\OpenAi\Model\ResourceModel\ExpandingWebOpenAiLog as Resource;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ExpandingWebOpenAiLogRepository implements ExpandingWebOpenAiLogRepositoryInterface
{
    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var ExpandingWebOpenAiLogInterfaceFactory
     */
    private $openAiLogFactory;

    /**
     * @param Resource $resource
     * @param ExpandingWebOpenAiLogInterfaceFactory $openAiLogFactory
     */
    public function __construct(
        Resource $resource,
        ExpandingWebOpenAiLogInterfaceFactory $openAiLogFactory
    ) {
        $this->resource = $resource;
        $this->openAiLogFactory = $openAiLogFactory;
    }

    /**
     * @inheritDoc
     */
    public function save(ExpandingWebOpenAiLogInterface $model): ExpandingWebOpenAiLogInterface
    {
        try {
            $this->resource->save($model);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $value): ExpandingWebOpenAiLogInterface
    {
        /**
         * @var ExpandingWebOpenAiLogInterface $model
         */
        $model = $this->openAiLogFactory->create();
        $this->resource->load($model, $value);
        if (!$model->getId()) {
            throw new NoSuchEntityException(
                __('The record with the "%1" ID doesn\'t exist.', $value)
            );
        }

        return $model;
    }
}
