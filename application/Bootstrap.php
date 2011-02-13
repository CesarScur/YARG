<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialization of registereds autoloaders
     */
    protected function _initAutoloader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->pushAutoloader(array('Doctrine', 'autoload'));
    	$autoloader->pushAutoloader(array('Doctrine_Core', 'modelsAutoload'));

    }


    protected function _initModules()
    {
        $modelsPath = APPLICATION_PATH . DS . 'models';
        Zend_Registry::set('models', $modelsPath);
    }

    /**
     * Initialization of Db
     */
    protected function _initDbConn()
    {
    	require 'Doctrine-1.2.3'. DS . 'Doctrine.php';
    	$manager = Doctrine_Manager::getInstance();
        try {

            // driver://user:password@host/db
            $conn = Doctrine_Manager::connection('mysql://root:root@localhost/cms');

            $manager->setAttribute(Doctrine_Core::ATTR_FIELD_CASE, CASE_LOWER);
            $manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING,
                                   Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
            $manager->setAttribute(Doctrine_Core::ATTR_EXPORT,
                                   Doctrine_Core::EXPORT_ALL);

            $profiler = new Doctrine_Connection_Profiler();
            $manager->setListener($profiler);

        } catch (Doctrine_Manager_Exception $e) {
            print $e->getMessage();
        }

        $modelsPath = Zend_Registry::get('models');
        try {
            Doctrine::generateModelsFromDb(realpath($modelsPath));
        } catch (Doctrine_Import_Builder_Exception $e) {
            $msg = $e->getMessage();
        }

        Doctrine_Core::loadModels($modelsPath);
    }

    /**
     * Initioalization of Cache
     */
    protected function _initSession()
    {
    	Zend_Session::start();
    }


    /**
     * Initioalization of Cache
     */
    protected function _initCache()
    {
        $frontendOptions = array(
        	'lifetime' => 3600, // cache lifetime of 1 hours
        	'automatic_serialization' => true
        );
        $backendOptions = array(
            'cache_dir' => '../cache/'
        );
        $cache = Zend_Cache::factory('Core',
                                     'File',
                                     $frontendOptions,
                                     $backendOptions);
        Zend_Registry::set('cacheFile', $cache);

   }

}

