<?php


class aInsetImageSlotTable extends PluginaInsetImageSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aInsetImageSlot');
    }
}