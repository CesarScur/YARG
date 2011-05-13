<?php

class ConfigController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // action body
    }

    public function authAction()
    {
        // action body
    }

    public function connectionAction()
    {
        $form = new Application_Form_Config_Connection();

        if( $this->getRequest()->isPost() ) {
            if($form->isValid($this->getRequest()->getParams()) ) {
                $connection = new Connection();
                $connection->fromArray($this->getRequest()->getParams());
                $connection->save();
                Yarg_FlashMessenger::addMessage('Conexão adicionada!');
                Yarg_FlashMessenger::addMessage(
                    'Carregue os models da conexão para comessar a utilizar!',
                    Yarg_FlashMessenger::NOTICE
                );
            }
        }


        $connections = Doctrine::getTable('Connection')->findAll();

        //@TODO: nice place to a table display component =D

        $this->view->connections = $connections;
        $this->view->form = $form;


    }

    public function loadModelsAction()
    {
        $form = new Application_Form_Config_LoadModels();

        if( $this->getRequest()->isPost() ) {
            if($form->isValid($this->getRequest()->getParams()) ) {
                $modelsPath = Zend_Registry::get('models');

                $connections = Doctrine::getTable('Connection')->findAll()->toKeyValueArray('id', 'name');

                foreach( $connections as $connection) {
                    $connectionPath = $modelsPath . DS . $connection;
                    //@TODO if dir does not exists create $connectionPath

                    if( !is_dir($connectionPath) ) {
                        try {
                            mkdir($connectionPath);
                        } catch (Exception $e) {
                            throw new Exception('Erro ao criar pasta para models. Problema de permissão?');
                        }
                    }
                    try {
                        Doctrine::generateModelsFromDb(realpath($connectionPath), array($connection));
                        Yarg_FlashMessenger::clearCurrentMessages();
                        Yarg_FlashMessenger::addMessage("Models Carregados em $connectionPath para $connection");

                    } catch (Doctrine_Import_Builder_Exception $e) {
                        Yarg_FlashMessenger::addMessage($e->getMessage(),
                            Yarg_FlashMessenger::ERROR);
                    }
                }

                $this->_redirect('');
            }
        }

        $this->view->form = $form;
    }

    public function removeConnectionAction()
    {
        $id = $this->getRequest()->getParam('id');
        $connection = Doctrine::getTable('Connection')->find($id);
        if( $connection ) {
            $connection->delete();
            Yarg_FlashMessenger::addMessage("Conexão {$connection->name} removida!");
        } else {
            Yarg_FlashMessenger::addMessage("Id de conxão a ser removido é inválido! Best luck next time =D",
                Yarg_FlashMessenger::ERROR);
        }
        $this->_redirect('config/connection');
    }
    
}









