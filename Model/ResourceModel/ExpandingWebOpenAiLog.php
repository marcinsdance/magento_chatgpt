<?php
namespace ExpandingWeb\OpenAi\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use ExpandingWeb\OpenAi\Api\Data\ExpandingWebOpenAiLogInterface;

class ExpandingWebOpenAiLog extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'expandingweb_openai_log_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(ExpandingWebOpenAiLogInterface::TABLE_NAME, ExpandingWebOpenAiLogInterface::ID);
        $this->_useIsObjectNew = true;
    }
}
