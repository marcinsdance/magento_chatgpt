<?php
declare(strict_types=1);

namespace ExpandingWeb\OpenAi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface ExpandingWebOpenAiLogInterface extends ExtensibleDataInterface
{
    public const TABLE_NAME = 'expandingweb_openai_log';
    public const ID = 'id';
    public const REQUEST = 'request';
    public const RESPONSE = 'response';
    public const CREATED_AT = 'created_at';

    /**
     * Get Log Id
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Get Request
     *
     * @return string|null
     */
    public function getRequest(): string;

    /**
     * Set Request
     *
     * @param string $value
     *
     * @return ExpandingWebOpenAiLogInterface
     */
    public function setRequest(string $value): ExpandingWebOpenAiLogInterface;

    /**
     * Get Response
     *
     * @return string|null
     */
    public function getResponse(): string;

    /**
     * Set Response
     *
     * @param string $value
     *
     * @return ExpandingWebOpenAiLogInterface
     */
    public function setResponse(string $value): ExpandingWebOpenAiLogInterface;

    /**
     * Get date create
     *
     * @return string|null
     */
    public function getCreatedAt(): string;
}
