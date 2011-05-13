<?php

/**
 * Report Form
 *
 * @author Sugar
 */
class Application_Form_Report
    extends Zend_Form
{

    function init()
    {

        $this->setMethod('post');

        $this->addElement(new Zend_Dojo_Form_Element_TextBox('name',
            array(
                'required' => true,
                'label' => 'Nome',
                )
        ));

        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('submit',
            array('label' => 'Salvar')
        ));



    }

}
?>
