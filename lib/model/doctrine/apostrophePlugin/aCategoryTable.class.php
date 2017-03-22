<?php


class aCategoryTable extends PluginaCategoryTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aCategory');
    }
}