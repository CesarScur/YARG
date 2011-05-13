<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));


//Short cut
defined('DS')
    || define('DS', DIRECTORY_SEPARATOR);


// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));

$manager = Doctrine_Manager::getInstance();

try {
    // driver://user:password@host/db

    $dbPath = realpath(APPLICATION_PATH . DS . '../db/db.sqlite');
    $conn = Doctrine_Manager::connection("sqlite://$dbPath", 'main');
} catch (Doctrine_Manager_Exception $e) {
    print $e->getMessage();
}

$manager->setAttribute(Doctrine_Core::ATTR_FIELD_CASE, CASE_LOWER);
$manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING,
                       Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
$manager->setAttribute(Doctrine_Core::ATTR_EXPORT,
                       Doctrine_Core::EXPORT_ALL);

