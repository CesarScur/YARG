<?php
/**
 * Gerate the models from the application internal database
 * 
 */


require 'bootstrap.php';



try {
    Doctrine::generateModelsFromYaml(APPLICATION_PATH . DS . 'models', APPLICATION_PATH . DS . 'models');
} catch (Doctrine_Import_Builder_Exception $e) {
    $msg = $e->getMessage();
}


Doctrine_Manager::getInstance()->getConnection('main')->close();
echo 'Model loaded from YAML!!';



