<?php


class aFileSlotTable extends PluginaFileSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aFileSlot');
    }
}