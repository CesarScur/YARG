<?php

class ReportController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $modelsPath = Zend_Registry::get('models');
        $modelsFolder = dir($modelsPath);

        $modelTables = array();
        while($entry = $modelsFolder->read()) {
            list($class) = explode('.', $entry);
            if( $class . ".php" != $entry ) {
                continue;
            }

            $modelTables[] =  Doctrine::getTable($class);
        }
        $this->view->models = $modelTables;
    }

    public function joinAction()
    {
        $request = $this->getRequest();
        $model = $request->getParam('model');
        $modelTable = Doctrine::getTable($model);
        $this->view->relations = $modelTable->getRelations();
    }

    public function fieldAction()
    {
        $request = $this->getRequest();
        $model = $request->getParam('model');
        $modelTable = Doctrine::getTable($model);

        $this->view->columnNames = $modelTable->getColumnNames();
    }

    public function generateAction()
    {
        $request = $this->getRequest();
        $model = $request->getParam('model');
        $column = $request->getParam('column');
        $modelTable = Doctrine::getTable($model);

        $this->view->modelTable = $modelTable->findAll();
        $this->view->columns = $column;
    }


}







