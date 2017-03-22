<?php


class aInsetAreaSlotTable extends PluginaInsetAreaSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aInsetAreaSlot');
    }
}