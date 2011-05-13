<?php

class Application_Form_Join extends Zend_Form
{

    public function init()
    {

        $joinOptions = $this->getAttrib('joinOptions');


        $this->setMethod('post');
        $this->setAction('/report/join');

        $this->setAttrib('id', 'form');



        /**
         * Join Field
         */
        $this->addElement(new Zend_Dojo_Form_Element_FilteringSelect('joinModel', array(
            'label' => 'Join with',
            'multiOptions' => $joinOptions
        )));

        /**
         * Add Button
         */
        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('add', array(
            'label' => 'Adicionar'
        )));

    }
}

