<?php

namespace Ess\M2ePro\Controller\Adminhtml\Amazon\Listing\Product\Add;

class CheckSearchResults extends \Ess\M2ePro\Controller\Adminhtml\Amazon\Listing\Product\Add
{
    public function execute()
    {
        $listingId = $this->getRequest()->getParam('id');
        $listingProductsIds = $this->getListing()->getSetting('additional_data', 'adding_listing_products_ids');

        if (empty($listingId) || empty($listingProductsIds)) {
            $this->_forward('index');
        }

        $listingProductsIds = $this->filterProductsForNewAsin($listingProductsIds);

        if (empty($listingProductsIds) ||
            !$this->getListing()->getMarketplace()->getChildObject()->isNewAsinAvailable()) {

            $redirectUrl = $this->getUrl('*/*/index', array(
                'step' => 5,
                'id' => $this->getRequest()->getParam('id')
            ));
            $this->setJsonContent(['redirect' => $redirectUrl]);

            return $this->getResult();
        }

        $this->getListing()
            ->setSetting('additional_data', 'adding_new_asin_listing_products_ids', $listingProductsIds)
            ->save();

        $showNewAsinStep = $this->getListing()->getSetting('additional_data', 'show_new_asin_step');
        if (isset($showNewAsinStep)) {
            $this->setJsonContent([
                'redirect' => $this->getUrl('*/*/index', array(
                    'id' => $this->getRequest()->getParam('id'),
                    'step' => $showNewAsinStep ? 4 : 5
                ))
            ]);

            return $this->getResult();
        }

        $newAsinPopup = $this->createBlock('Amazon\Listing\Product\Add\SearchAsin\NewAsinPopup');

        $this->setJsonContent(['html' => $newAsinPopup->toHtml()]);

        return $this->getResult();
    }
}