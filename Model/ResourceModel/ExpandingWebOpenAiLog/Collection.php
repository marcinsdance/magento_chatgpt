<?php
namespace ExpandingWeb\OpenAi\Model\ResourceModel\ExpandingWebOpenAiLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SkySwitch\ClickOnBanner\Model\ResourceModel\ExpandingWebOpenAiLog as ResourceModel;
use SkySwitch\ClickOnBanner\Model\ExpandingWebOpenAiLog as Model;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'expandingweb_openai_log_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
