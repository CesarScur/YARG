<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CorePage', 'Cms conn');

/**
 * BaseCorePage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $page_id
 * @property string $route
 * @property string $title
 * @property integer $ordering
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCorePage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('core_page');
        $this->hasColumn('page_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('route', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('title', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('ordering', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}