<?php


class aSmartSlideshowSlotTable extends PluginaSmartSlideshowSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aSmartSlideshowSlot');
    }
}