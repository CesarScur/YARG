<?php
/**
 * Form for selectcting the base repot model
 *
 * @author Sugar
 */
class Application_Form_Model
    extends Zend_Form
{
    public function init() {

        $this->setMethod('post');
        
        $this->addElement(new Zend_Dojo_Form_Element_FilteringSelect('baseModel',
            array(
                'label' => 'Model',
            )
        ));

        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('submit',
            array(
                'label' => 'Selecionar'
            )
        ));

    }
    
}
