<?php
namespace ExpandingWeb\OpenAi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use OpenAI;
use ExpandingWeb\OpenAi\Api\Data\ExpandingWebOpenAiLogInterfaceFactory;
use ExpandingWeb\OpenAi\Api\ExpandingWebOpenAiLogRepositoryInterface;
use Magento\Framework\Serialize\Serializer\Json;

class Data extends AbstractHelper
{
    public const SECTION_PATH = 'expanding_web_open_ai';

    public const API_KEY_PATH = 'general/api_key';

    public const DESCRIPTION = 'description_from_ai';

    public const META_TITLE = 'meta_title_from_ai';

    public const META_KEYWORD = 'meta_keyword_from_ai';

    public const META_DESCRIPTION = 'meta_description_from_ai';

    public const MAP_FIELDS = [
        self::DESCRIPTION => [
            'prefix_question' => 'Create description for',
            'mgt_field_id' => 'description'
        ],
        self::META_TITLE => [
            'prefix_question' => 'Create meta title for',
            'mgt_field_id' => 'meta_title'
        ],
        self::META_KEYWORD => [
            'prefix_question' => 'Create meta keywords for',
            'mgt_field_id' => 'meta_keyword'
        ],
        self::META_DESCRIPTION => [
            'prefix_question' => 'Create meta description for',
            'mgt_field_id' => 'meta_description'
        ],
    ];

    private const AI_MODEL = 'text-davinci-003';

    private const AI_TEMPERATURE = 0.9;

    private const AI_MAX_TOKENS = 1024;

    private const AI_TOP_P = 0.9;

    private const AI_N = 1;

    /**
     * @var OpenAI
     */
    private $openAi;

    /**
     * @var ExpandingWebOpenAiLogInterfaceFactory
     */
    private $openAiLogFactory;

    /**
     * @var ExpandingWebOpenAiLogRepositoryInterface
     */
    private $openAiLogRepository;

    /**
     * @var Json
     */
    private $json;
    
    /**
     * @param Context $context
     * @param OpenAI $openAi
     * @param ExpandingWebOpenAiLogInterfaceFactory $openAiLogFactory
     * @param ExpandingWebOpenAiLogRepositoryInterface $openAiLogRepository
     * @param Json $json
     */
    public function __construct(
        Context $context,
        OpenAI $openAi,
        ExpandingWebOpenAiLogInterfaceFactory $openAiLogFactory,
        ExpandingWebOpenAiLogRepositoryInterface $openAiLogRepository,
        Json $json
    ) {
        $this->openAi = $openAi;
        $this->openAiLogFactory = $openAiLogFactory;
        $this->openAiLogRepository = $openAiLogRepository;
        $this->json = $json;
        parent::__construct($context);
    }

    /**
     * Get API Key
     *
     * @return string||null
     */
    private function getApiKey()
    {
        return $this->scopeConfig->getValue(
            self::SECTION_PATH.'/'.self::API_KEY_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Answer from AI
     *
     * @param string $question
     *
     * @return string
     */
    public function getAnswer(string $question)
    {
        if (!empty($this->getApiKey())) {
            $openAi = $this->openAi->client($this->getApiKey());
            $result = $openAi->completions()->create([
                'model' => self::AI_MODEL,
                'prompt' => $question,
                'temperature' => self::AI_TEMPERATURE,
                'max_tokens' => self::AI_MAX_TOKENS,
                'top_p' => self::AI_TOP_P,
                'n' => self::AI_N
            ]);

            // create log if result be returned
            if ($result) {
                $modelOpenAiLog = $this->openAiLogFactory->create();
                $modelOpenAiLog->setRequest($question);
                $modelOpenAiLog->setResponse($this->json->serialize($result));
                $this->openAiLogRepository->save($modelOpenAiLog);
            }

            return $result['choices'][0]['text'];
        }

        return null;
    }

    /**
     * Get Prefix for Question
     *
     * @param string $fieldIndex
     *
     * @return string
     */
    public function getPrefixQuestion(string $fieldIndex)
    {
        if (isset(self::MAP_FIELDS[$fieldIndex])) {
            return self::MAP_FIELDS[$fieldIndex]['prefix_question'];
        }
        
        return null;
    }

    /**
     * Get Magento field index
     *
     * @param string $fieldIndex
     *
     * @return string
     */
    public function getMgtFieldIndex(string $fieldIndex)
    {
        if (isset(self::MAP_FIELDS[$fieldIndex])) {
            return self::MAP_FIELDS[$fieldIndex]['mgt_field_id'];
        }
        
        return null;
    }
}
