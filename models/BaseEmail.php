<?php

/**
 * BaseEmail
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $idemails
 * @property string $subject
 * @property text $body
 * @property timestamp $addDate
 * @property EmailPackage $EmailPackage
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmail extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('emails');
        $this->hasColumn('idemails', 'integer', null, array(
             'primary' => true,
             'unsigned' => true,
             'autoincrement' => true,
             'type' => 'integer',
             ));
        $this->hasColumn('subject', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('body', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('addDate', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('EmailPackage', array(
             'local' => 'idemails',
             'foreign' => 'email_id'));
    }
}