<?php


class fParkSlotTable extends aSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('fParkSlot');
    }
}