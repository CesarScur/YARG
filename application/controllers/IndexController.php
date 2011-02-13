<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $modelsPath = Zend_Registry::get('models');
        $modelsFolder = dir($modelsPath);

        while($entry = $modelsFolder->read()) {
            list($class) = explode('.', $entry);
            if( $class . ".php" != $entry ) {
                continue;
            }

            $table =  Doctrine::getTable($class);
            Zend_Debug::dump($class);
            Zend_Debug::dump($table->getColumnNames());
        }


    }


}

