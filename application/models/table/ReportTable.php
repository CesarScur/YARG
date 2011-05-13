<?php
class ReportTable
{
    static $tableName = 'Report';


    /**
     *
     * @return Report
     */
    static function getUnsavedReport() {
        return self::getTable()->createQuery()
                               ->where('unsaved = 1')
                               ->fetchOne();
    }


    /**
     *
     * @return Doctrine_Table
     */
    static function getTable() {
        return Doctrine::getTable(self::$tableName);
    }


    /**
     *
     * @param integer $id
     * @return Report
     */
    static function find($id)  {
        return self::getTable()->find($id);
    }

}