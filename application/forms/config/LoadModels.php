<?php

class Application_Form_Config_LoadModels extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAction('/config/load-models');



        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('submit', array(
            'label' => 'Rodar Procedimento'
        )));
    }

}

