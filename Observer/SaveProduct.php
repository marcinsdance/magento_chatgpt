<?php
namespace ExpandingWeb\OpenAi\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveProduct implements ObserverInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $productController = $observer->getController();
        $data = $productController->getRequest()->getParam('product');
        $mainProduct = $observer->getProduct();
        if (isset($data['description_from_ai']) && !empty($data['description_from_ai'])) {
            $fieldData = $data['description_from_ai'];
            $htmlData = '<div data-content-type="row" data-appearance="contained" data-element="main">';
            $htmlData .= '<div data-element="inner">';
            $htmlData .= '<div data-content-type="text" data-appearance="default" data-element="main">';
            $htmlData .= '<p>'.nl2br($fieldData).'</p>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $htmlData .= '</div>';
            $mainProduct->setShortDescription($fieldData);
            $mainProduct->setDescription($htmlData);
            $mainProduct->save();
        }
    }
}
