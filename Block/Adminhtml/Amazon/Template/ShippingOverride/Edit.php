<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Block\Adminhtml\Amazon\Template\ShippingOverride;

class Edit extends \Ess\M2ePro\Block\Adminhtml\Amazon\Template\Edit
{
    //########################################

    public function _construct()
    {
        parent::_construct();

        $this->_controller = 'adminhtml_amazon_template_shippingOverride';

        $this->removeButton('back');
        $this->removeButton('reset');
        $this->removeButton('delete');
        $this->removeButton('add');
        $this->removeButton('save');
        $this->removeButton('edit');
        // ---------------------------------------

        // ---------------------------------------
        $url = $this->getHelper('Data')->getBackUrl('list');
        $this->addButton('back', array(
            'label'     => $this->__('Back'),
            'onclick'   => 'AmazonTemplateShippingOverrideObj.backClick(\'' . $url . '\')',
            'class'     => 'back'
        ));
        // ---------------------------------------

        $isSaveAndClose = (bool)$this->getRequest()->getParam('close_on_save', false);

        if (!$isSaveAndClose
            && $this->getHelper('Data\GlobalData')->getValue('tmp_template')
            && $this->getHelper('Data\GlobalData')->getValue('tmp_template')->getId()
        ) {
            // ---------------------------------------
            $this->addButton('duplicate', array(
                'label'   => $this->__('Duplicate'),
                'onclick' => 'AmazonTemplateShippingOverrideObj.duplicateClick'
                    .'(\'amazon-template-shippingOverride\')',
                'class'   => 'action-primary M2ePro_duplicate_button'
            ));
            // ---------------------------------------

            // ---------------------------------------
            $this->addButton('delete', array(
                'label'     => $this->__('Delete'),
                'onclick'   => 'AmazonTemplateShippingOverrideObj.deleteClick()',
                'class'     => 'action-primary delete M2ePro_delete_button'
            ));
            // ---------------------------------------
        }

        // ---------------------------------------

        $saveButtonOptions = [];

        if ($isSaveAndClose) {
            $saveButtonOptions['save'] = [
                'label' => $this->__('Save And Close'),
                'onclick' => "AmazonTemplateShippingOverrideObj.saveAndCloseClick()"
            ];
            $this->removeButton('back');
        } else {
            $saveButtonOptions['save'] = [
                'label'     => $this->__('Save And Back'),
                'onclick'   =>'AmazonTemplateShippingOverrideObj.saveClick('
                    . '\'\','
                    . '\'' . $this->getSaveConfirmationText() . '\','
                    . '\'' . \Ess\M2ePro\Block\Adminhtml\Amazon\Template\Grid::TEMPLATE_SHIPPING_OVERRIDE . '\''
                    . ')',
                'class'     => 'save primary'
            ];
        }
        // ---------------------------------------

        $saveButtons = [
            'id' => 'save_and_continue',
            'label' => $this->__('Save And Continue Edit'),
            'class' => 'add',
            'button_class' => '',
            'onclick'   => 'AmazonTemplateShippingOverrideObj.saveAndEditClick('
                . '\'\','
                . 'undefined,'
                . '\'' . $this->getSaveConfirmationText() . '\','
                . '\'' . \Ess\M2ePro\Block\Adminhtml\Amazon\Template\Grid::TEMPLATE_SHIPPING_OVERRIDE . '\''
                . ')',
            'class_name' => 'Ess\M2ePro\Block\Adminhtml\Magento\Button\SplitButton',
            'options' => $saveButtonOptions,
        ];

        $this->addButton('save_buttons', $saveButtons);

        $this->css->addFile('amazon/template.css');
        // ---------------------------------------
    }

    //########################################
}