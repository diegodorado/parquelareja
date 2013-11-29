<?php


class aCategoryUserTable extends PluginaCategoryUserTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aCategoryUser');
    }
}