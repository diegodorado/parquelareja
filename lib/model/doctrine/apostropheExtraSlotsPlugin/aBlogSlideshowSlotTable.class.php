<?php


class aBlogSlideshowSlotTable extends PluginaBlogSlideshowSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aBlogSlideshowSlot');
    }
}