<?php

/**
 * BaseaPageToCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $page_id
 * @property integer $category_id
 * @property aCategory $aCategory
 * @property aPage $aPage
 * 
 * @method integer         get()            Returns the current record's "page_id" value
 * @method integer         get()            Returns the current record's "category_id" value
 * @method aCategory       get()            Returns the current record's "aCategory" value
 * @method aPage           get()            Returns the current record's "aPage" value
 * @method aPageToCategory set()            Sets the current record's "page_id" value
 * @method aPageToCategory set()            Sets the current record's "category_id" value
 * @method aPageToCategory set()            Sets the current record's "aCategory" value
 * @method aPageToCategory set()            Sets the current record's "aPage" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseaPageToCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('a_page_to_category');
        $this->hasColumn('page_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('category_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('aCategory', array(
             'local' => 'category_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('aPage', array(
             'local' => 'page_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}