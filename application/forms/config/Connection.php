<?php

class Application_Form_Config_Connection extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAction('/config/connection');


        $this->addElement(new Zend_Dojo_Form_Element_ValidationTextBox('name', array(
            'label' => 'Nome',
            'required' => true,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_FilteringSelect('driver', array(
            'label' => 'Driver',
            'required' => true,
            'multiOptions' => array(
                'mysql' => 'MySql',
                'oci' => 'Oracle',
                'pgsql' => 'Postgre',
                'mssql' => 'MsSql',
                'sqlite' => 'Sqlite',
            ),
        )));


        $this->addElement(new Zend_Dojo_Form_Element_TextBox('host', array(
            'label' => 'Host',
            'value' => 'localhost',
            'required' => true,
        )));


        $this->addElement(new Zend_Dojo_Form_Element_TextBox('port', array(
            'label' => 'Porta',
            'required' => true,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_TextBox('user', array(
            'label' => 'Usuários',
            'required' => true,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_TextBox('pass', array(
            'label' => 'Senha',
            'required' => true,
        )));

        $this->addElement(new Zend_Dojo_Form_Element_TextBox('database', array(
            'label' => 'Banco',
            'required' => true,
        )));


        $this->addElement(new Zend_Dojo_Form_Element_SubmitButton('submit', array(
            'label' => 'Adicionar'
        )));
    }

}

