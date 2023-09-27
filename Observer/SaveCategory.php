<?php
namespace ExpandingWeb\OpenAi\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveCategory implements ObserverInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $request = $observer->getRequest();
        $descriptionFromAi = $request->getParam('description_from_ai');
        $mainCategory = $observer->getCategory();
        if ($descriptionFromAi) {
            $htmlData = '<div data-content-type="row" data-appearance="contained" data-element="main">';
            $htmlData .= '<div data-element="inner">';
            $htmlData .= '<div data-content-type="text" data-appearance="default" data-element="main">';
            $htmlData .= '<p>'.nl2br($descriptionFromAi).'</p>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $mainCategory->setDescription($htmlData);
        }
    }
}
