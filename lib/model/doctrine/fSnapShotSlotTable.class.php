<?php


class fSnapShotSlotTable extends aSlotTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('fSnapShotSlot');
    }
}