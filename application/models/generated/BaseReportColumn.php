<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ReportColumn', 'main');

/**
 * BaseReportColumn
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property text $column
 * @property integer $reportId
 * @property Report $Report
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReportColumn extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('report_column');
        $this->hasColumn('id', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '8',
             ));
        $this->hasColumn('column', 'text', null, array(
             'type' => 'text',
             'notnull' => true,
             'length' => '',
             ));
        $this->hasColumn('report_id as reportId', 'integer', 8, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '8',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Report', array(
             'local' => 'reportId',
             'foreign' => 'id'));
    }
}