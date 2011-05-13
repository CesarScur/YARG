<?php
/**
 * Create tables based on model definitions
 */

require 'bootstrap.php';



try {
    Doctrine::createTablesFromModels(APPLICATION_PATH . DS . 'models');
} catch (Doctrine_Import_Builder_Exception $e) {
    $msg = $e->getMessage();
}


Doctrine_Manager::getInstance()->getConnection('main')->close();
echo 'Tables created from models!!';


