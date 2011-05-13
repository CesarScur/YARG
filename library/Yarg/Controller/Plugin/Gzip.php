<?php
class Yarg_Controller_Plugin_Gzip
    extends Zend_Controller_Plugin_Abstract
{

    private $_config = array();


    public function dispatchLoopShutdown()
    {
        $body = $this->_response->getBody();
        $body = ob_gzhandler($body, 5);
        $this->_response->setBody($body);

        //$headers = $this->_response->setHeader('Content-Encoding', 'gzip');

    }

    public function __construct()
    {
    }

}
