<?php


class aPageToCategoryTable extends PluginaPageToCategoryTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aPageToCategory');
    }
}