<?php
namespace ExpandingWeb\OpenAi\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveCmsPage implements ObserverInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $request = $observer->getRequest();
        $contentFromAi = $request->getParam('content_from_ai');
        $pageModel = $observer->getPage();
        if ($contentFromAi) {
            $htmlData = '<div data-content-type="row" data-appearance="contained" data-element="main">';
            $htmlData .= '<div data-element="inner">';
            $htmlData .= '<div data-content-type="text" data-appearance="default" data-element="main">';
            $htmlData .= '<p>'.nl2br($contentFromAi).'</p>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $pageModel->setContent($htmlData);
        }
    }
}
