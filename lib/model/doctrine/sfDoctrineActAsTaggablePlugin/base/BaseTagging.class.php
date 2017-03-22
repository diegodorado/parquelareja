<?php

/**
 * BaseTagging
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tag_id
 * @property string $taggable_model
 * @property integer $taggable_id
 * @property Tag $Tag
 * 
 * @method integer get()               Returns the current record's "tag_id" value
 * @method string  get()               Returns the current record's "taggable_model" value
 * @method integer get()               Returns the current record's "taggable_id" value
 * @method Tag     get()               Returns the current record's "Tag" value
 * @method Tagging set()               Sets the current record's "tag_id" value
 * @method Tagging set()               Sets the current record's "taggable_model" value
 * @method Tagging set()               Sets the current record's "taggable_id" value
 * @method Tagging set()               Sets the current record's "Tag" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTagging extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tagging');
        $this->hasColumn('tag_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('taggable_model', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('taggable_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('tag', array(
             'fields' => 
             array(
              0 => 'tag_id',
             ),
             ));
        $this->index('taggable', array(
             'fields' => 
             array(
              0 => 'taggable_model',
              1 => 'taggable_id',
             ),
             ));

        $this->setAttribute(Doctrine_Core::ATTR_EXPORT, Doctrine_Core::EXPORT_ALL ^ Doctrine_Core::EXPORT_CONSTRAINTS);
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Tag', array(
             'local' => 'tag_id',
             'foreign' => 'id'));
    }
}