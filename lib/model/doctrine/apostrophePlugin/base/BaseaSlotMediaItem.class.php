<?php

/**
 * BaseaSlotMediaItem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $media_item_id
 * @property integer $slot_id
 * @property aMediaItem $aMediaItem
 * @property aSlot $aSlot
 * 
 * @method integer        get()              Returns the current record's "media_item_id" value
 * @method integer        get()              Returns the current record's "slot_id" value
 * @method aMediaItem     get()              Returns the current record's "aMediaItem" value
 * @method aSlot          get()              Returns the current record's "aSlot" value
 * @method aSlotMediaItem set()              Sets the current record's "media_item_id" value
 * @method aSlotMediaItem set()              Sets the current record's "slot_id" value
 * @method aSlotMediaItem set()              Sets the current record's "aMediaItem" value
 * @method aSlotMediaItem set()              Sets the current record's "aSlot" value
 * 
 * @package    symfony
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseaSlotMediaItem extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('a_slot_media_item');
        $this->hasColumn('media_item_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('slot_id', 'integer', null, array(
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
        $this->hasOne('aMediaItem', array(
             'local' => 'media_item_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('aSlot', array(
             'local' => 'slot_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}