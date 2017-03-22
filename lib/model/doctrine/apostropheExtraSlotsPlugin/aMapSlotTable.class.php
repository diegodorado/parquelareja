<?php


class aMapSlotTable extends PluginaMapSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aMapSlot');
    }
}