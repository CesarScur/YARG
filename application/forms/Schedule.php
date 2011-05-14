<?php

class Application_Form_Schedule extends Zend_Dojo_Form
{

    public function init()
    {
        $this->setMethod('post');

        $this->setAttrib('class', 'linear_form');

        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('minute', array(
            'label' => 'Minutos',
            'required' => true,
            'value' => 0,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('hour', array(
            'label' => 'Horas',
            'required' => true,
            'value' => 0,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('day', array(
            'label' => 'Dias',
            'required' => true,
            'value' => 0,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('month', array(
            'label' => 'Meses',
            'required' => true,
            'value' => 0,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('year', array(
            'label' => 'Anos',
            'required' => true,
            'value' => 0,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('weekday', array(
            'label' => 'Dias das Semanas',
            'required' => true,
            'value' => '0-6',
        )));

        $this->addElement('filteringSelect', 'method', array(
            'label' => 'Metodo',
            'multiOptions' => array(
                'email' => 'email'
            ),
            'required' => true,

        ));

        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('submit', array(
            'label' => 'Agendar',
        )));


    }


}

