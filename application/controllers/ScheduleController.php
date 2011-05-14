<?php

class ScheduleController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $schedules = Doctrine::getTable('Schedule')->findAll();
        $form = new Application_Form_Schedule();
        $request = $this->getRequest();

        if( $request->isPost() ){
            if( $form->isValid($request->getParams()) ){
                $schedule = new Schedule();
                $schedule->fromArray($form->getValues());
                $schedule->save();

                Yarg_FlashMessenger::addMessage('Adicionado um novo agendamento!');
                $this->_redirect('/schedule');
            }
        }

        $this->view->form = $form;
        $this->view->schedules = $schedules;

    }

    public function removeAction()
    {
        // action body
    }


}





