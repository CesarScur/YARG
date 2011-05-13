<?php
class Yarg_Controller_Plugin_Tidy
    extends Zend_Controller_Plugin_Abstract
{

    private $_config = array();
    private $_encode = 'utf8';


    public function dispatchLoopShutdown()
    {
        $body = $this->_response->getBody();
        $tidy = new Tidy();
        $body = $tidy->repairString($body, $this->_config, $this->_encode);
        $this->_response->setBody($body);
    }

    public function __construct()
    {
        /*
        //$this->_config["show-body-only"]=true;
        $this->_config["wrap"]=0;
        $this->_config["wrap-attributes"]=0;
        //$this->_config["preserve-entities"]=1;
        $this->_config["output-xhtml"]=1;
        $this->_config["new-inline-tags"]='go';
        $this->_config['fix-bad-comments']='no';
        $this->_config['hide-comments']='no';
        $this->_config['drop-empty-paras']='yes';
         *
         */
    }
    
}
