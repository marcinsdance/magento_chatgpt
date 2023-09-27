<?php
namespace ExpandingWeb\OpenAi\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use ExpandingWeb\OpenAi\Api\Data\ExpandingWebOpenAiLogInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * @api
 */
interface ExpandingWebOpenAiLogRepositoryInterface
{
    /**
     * Save
     *
     * @param ExpandingWebOpenAiLogInterface $model
     *
     * @return ExpandingWebOpenAiLogInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(ExpandingWebOpenAiLogInterface $model): ExpandingWebOpenAiLogInterface;

    /**
     * Save
     *
     * @param int $value
     *
     * @return ExpandingWebOpenAiLogInterface
     *
     * @throws NoSuchEntityException
     */
    public function getById(int $value): ExpandingWebOpenAiLogInterface;
}
