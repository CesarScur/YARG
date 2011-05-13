<?php

class ReportController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $reports = ReportTable::getTable()
            ->findAll();

        $this->view->reports = $reports;
        
    }

    public function createAction()
    {
        $request = $this->getRequest();

        if($request->isPost()) {
            $report = new Report();
            $report->baseModel = $request->getParam('baseModel');

            $report->save();
        }

        if(ReportTable::getUnsavedReport()) {
            //@TODO: Você tem um report não salvo, deseja continuar ou descartar?

            $this->_redirect('/report/join');
        }


        $modelsPath = Zend_Registry::get('models');
        $models = Doctrine_Core::filterInvalidModels(Doctrine_Core::loadModels($modelsPath));

        $ajustedModels = array();
        foreach( $models as $model ) {
            $ajustedModels[$model] = $model;
        }
        $models = $ajustedModels;



        $form = new Application_Form_Model();
        $form->getElement('baseModel')->setMultiOptions($models);


        $this->view->form = $form;
    }

    public function joinAction()
    {
        $request = $this->getRequest();

        $report = ReportTable::getUnsavedReport();



        if( !$report )  {
            $this->_redirect('/report');
        }

        if($request->isPost()) {
            $joinModel = $request->getParam('joinModel');

            $reportJoin =  new ReportJoin();
            $reportJoin->model = $joinModel;
            $reportJoin->reportId = $report->id;
            
            $reportJoin->save();
        }

        

        /**
         * @todo: change to recursive relations based on $model plus $joinModels
         */
        $modelTable = Doctrine::getTable($report->baseModel);
        $relations = $modelTable->getRelations();
        $joinOptions = $this->_getRelationsOptions($relations);



        $config = array(
            'joinOptions' =>  $joinOptions
        );
        $form = new Application_Form_Join($config);


        $this->view->form = $form;
        $this->view->report = $report;
    }


    public function removeJoinAction()
    {
        $request = $this->getRequest();
        $joinModelId = $request->getParam('joinModel');

        $report = ReportTable::getUnsavedReport();

        if( !$report )  {
            $this->_redirect('/report');
        }


        $reportModel = Doctrine_Query::create()
            ->delete()
            ->from('ReportJoin')
            ->where('id = ?', array($joinModelId))
            ->andWhere('reportId = ?', array($report->id))
            ->execute();


       
        $this->_redirect('/report/join');
    }


    public function columnAction()
    {
        $request = $this->getRequest();
        $report = ReportTable::getUnsavedReport();

        if( !$report )  {
            $this->_redirect('/report');
        }


        if($request->isPost()) {
            $column = $request->getParam('column');

            $reportColumn =  new ReportColumn();
            $reportColumn->column = $column;
            $reportColumn->reportId = $report->id;

            $reportColumn->save();
        }



        $models = array_merge(
                (array) $report->baseModel,
                (array) $report->ReportJoin->toKeyValueArray('id', 'model')
        );


        $columnsOptions = array();
        foreach( (array) $models as $model ) {
            $columns = Doctrine::getTable($model)->getColumnNames();
            foreach( $columns as $column ) {
                $column = "$model->$column";
                $columnsOptions[$column] = $column;
            }
        }

        $form = new Application_Form_Column(array(
            'columnsOptions' => $columnsOptions,
        ));

        
        $this->view->form = $form;
        $this->view->report = $report;
    }


    public function removeColumnAction()
    {
        $request = $this->getRequest();
        $columnId = $request->getParam('id');

        $report = ReportTable::getUnsavedReport();

        if( !$report )  {
            $this->_redirect('/report');
        }

        Doctrine_Query::create()
            ->delete('ReportColumn')
            ->where('reportId = ?', array($report->id))
            ->andWhere('id = ?', array($columnId))
            ->execute();

        $this->_redirect('/report/column');

    }

    public function saveAction()
    {
        $request = $this->getRequest();
        $report = ReportTable::getUnsavedReport();

        if( !$report )  {
            $this->_redirect('/report');
        }

        $report->ReportColumn;
        $report->ReportJoin;

        Zend_Debug::dump($report->toArray(true));


        $form = new Application_Form_Report();

        if( $request->isPost() ) {
            if( $form->isValid($request->getParams()) ) {
                $report->name = $request->getParam('name');
                $report->unsaved = false;
                $report->save();

                $this->_redirect('/report');
            }
        }

        $this->view->form = $form;

    }


    public function generateAction()
    {
        $request = $this->getRequest();
        $report = ReportTable::find($request->getParam('report'));

        $q = Doctrine_Query::create();

        $columns = array();
        foreach( $report->ReportColumn as $column ) {
            $columns[] = str_replace('->', '.', $column->column);
        }
        $q->select(implode(', ', $columns));

        $q->from("{$report->baseModel} {$report->baseModel}");

        foreach( $report->ReportJoin as $model ) {
            $q->leftJoin("{$report->baseModel}.{$model->model} {$model->model}");
        }


        $data = array();
        try {
            $data = $q->execute(array(), Doctrine_Core::HYDRATE_NONE);
        } catch (Doctrine_Exception $e) {
            Yarg_FlashMessenger::addMessage('Existe algum problema com seus models?',
                Yarg_FlashMessenger::NOTICE);
        }
        $this->view->columns = $columns;
        $this->view->data = $data;
        
    }



    /**
     * Get the names of relations in the array
     * @param array(Doctrine_Relation) $relations
     * @return array
     */
    protected function _getRelationsOptions($relations)
    {
        $relationsOptions = array  ();
        foreach( $relations as $model ) {
            $relatedModelName = $model->getAlias();
            $relationsOptions[$relatedModelName] = $relatedModelName;
        }

        return $relationsOptions;
    }
    

}







