<?php
namespace ExpandingWeb\OpenAi\Plugin\Magento\Cms\Api;

use Magento\Cms\Api\BlockRepositoryInterface as MagentoBlockRepository;
use Magento\Cms\Api\Data\BlockInterface;

class BlockRepositoryInterface
{
    /**
     * Before Save Cms Block
     *
     * @param MagentoBlockRepository $subject
     * @param BlockInterface $block
     *
     * @return [BlockInterface]
     */
    public function beforeSave(MagentoBlockRepository $subject, BlockInterface $block)
    {
        $contentFromAi = $block->getData('content_from_ai');
        if ($contentFromAi) {
            $htmlData = '<div data-content-type="row" data-appearance="contained" data-element="main">';
            $htmlData .= '<div data-element="inner">';
            $htmlData .= '<div data-content-type="text" data-appearance="default" data-element="main">';
            $htmlData .= '<p>'.nl2br($contentFromAi).'</p>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $block->setContent($htmlData);
        }

        return [$block];
    }
}
