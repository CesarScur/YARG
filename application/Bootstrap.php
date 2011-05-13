<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Initialize View
     */
    protected function _initView()
    {
        $view = new Zend_View($this->getOptions());
        Zend_Dojo::enableView($view);

        $view->setEncoding("UTF-8");
        $view->doctype('XHTML1_STRICT');
        $view->headTitle()->setSeparator(' - ')->append('Yarg');

        $view->headMeta()->appendHttpEquiv('Content-Type',
                                           'text/html; charset=utf-8');

        $view->headLink()
             ->appendStylesheet('/css/reset.css')
             ->appendStylesheet('/css/style.css')
             ->appendStylesheet('/css/flashMessenger.css');



        $view->addHelperPath(
            'Yarg' . DS . 'View' . DS . 'Helper',
            'Yarg_View_Helper'
        );

        $view->dojo()->setDjConfigOption('parseOnLoad', true)
//                     ->setLocalPath('/js/dojo/dojo.js')
                     ->setLocalPath('/js/dojo/1.5/dojo/dojo.js')
//                     ->registerModulePath('../spindle', 'spindle')
                     ->addStyleSheetModule('dijit.themes.claro')
//                     ->addStylesheetModule('spindle.themes.spindle')
//                     ->requireModule('spindle.main')
//                     ->disable()
;
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);





        return $view;
    }

    /**
     * Initialization of registereds autoloaders
     */
    protected function _initAutoloader()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->pushAutoloader(array('Doctrine', 'autoload'));
    	$autoloader->pushAutoloader(array('Doctrine_Core', 'modelsAutoload'));

    }



    /**
     * Initialization of Db
     */
    protected function _initDbConn()
    {
    	require 'Doctrine.php';
    	$manager = Doctrine_Manager::getInstance();

       
       try {
            // driver://user:password@host/db
            //$conn = Doctrine_Manager::connection('sqlite://C:\Users\Sugar\Zend\workspaces\yarg\db\db.sqlite', 'main');
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



        /**
         * Setup the profiler
         */

//        $profiler = new Doctrine_Connection_Profiler();
//        $manager->setListener($profiler);




        Doctrine_Core::loadModels(APPLICATION_PATH . DS . 'models');




        $modelsPath = APPLICATION_PATH . DS . 'reportModels';
        Zend_Registry::set('models', $modelsPath);


        $connections = Doctrine::getTable('Connection')->findAll();

        foreach( $connections as $connection ) {
            $connectionString = $connection->driver . '://'
                              . $connection->user . ':'
                              . $connection->pass . '@'
                              . $connection->host . '/'
                              . $connection->database;

            try {
                // driver://user:password@host/db
                $conn = Doctrine_Manager::connection($connectionString, $connection->name);
            } catch (Doctrine_Manager_Exception $e) {
                print $e->getMessage();
            }

            $connectionPath = $modelsPath . DS . $connection->name;
            try {
                Doctrine_Core::loadModels($connectionPath);
            } catch (Doctrine_Exception $e) {
                Yarg_FlashMessenger::addMessage('Uma ou mais conexões precisam ser carregadas. Carregue os models.',
                    Yarg_FlashMessenger::WARNING);
                
                break;
            }
        }



        

    }

    /**
     * Initioalization of Cache
     */
    protected function _initSession()
    {

        /**
         * @todo: Change to session model with doctrine -> Zend_Session_SaveHandeler_Interface
         */
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



   /**
    * Load Navigation
    */

   protected function _initNavigation()
   {
       $pages = new Zend_Config_Yaml(APPLICATION_PATH . DS . 'configs' . DS . 'pages.yml');
       $container = new Zend_Navigation($pages);
       
       $view = $this->getResource('view');
       $view->navigation($container);
   }
}

