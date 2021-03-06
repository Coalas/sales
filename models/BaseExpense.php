<?php

/**
 * BaseExpense
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idexpenses
 * @property decimal $amount
 * @property integer $expcategory_id
 * @property timestamp $addDate
 * @property ExpCategory $ExpCategory
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExpense extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('expenses');
        $this->hasColumn('idexpenses', 'integer', null, array(
             'primary' => true,
             'unsigned' => true,
             'autoincrement' => true,
             'type' => 'integer',
             ));
        $this->hasColumn('amount', 'decimal', null, array(
             'type' => 'decimal',
             ));
        $this->hasColumn('expcategory_id', 'integer', null, array(
             'unsigned' => true,
             'type' => 'integer',
             ));
        $this->hasColumn('addDate', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ExpCategory', array(
             'local' => 'expcategory_id',
             'foreign' => 'idexpcategories'));
    }
}