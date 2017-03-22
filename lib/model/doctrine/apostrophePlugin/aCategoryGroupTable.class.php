<?php


class aCategoryGroupTable extends PluginaCategoryGroupTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aCategoryGroup');
    }
}