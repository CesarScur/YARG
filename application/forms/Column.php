<?php

class Application_Form_Column extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAction('/report/column');

        $columnsOptions = $this->getAttrib('columnsOptions');


        $this->addElement(new Zend_Dojo_Form_Element_FilteringSelect('column', array(
            'label' => 'Colunas a serem exibidas no report:',
            'multiOptions' => $columnsOptions
        )));
        

        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('submit', array(
            'label' => 'Adicionar coluna'
        )));
    }

}

