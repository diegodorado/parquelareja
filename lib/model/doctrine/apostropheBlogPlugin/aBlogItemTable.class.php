<?php


class aBlogItemTable extends PluginaBlogItemTable
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('aBlogItem');
    }
    
    public function addPublished(Doctrine_Query $q)
    {
      /*to allow showing future posts*/
      $rootAlias = $q->getRootAlias();
      $q->addWhere($rootAlias.'.status = ?', 'published');
    }
      
}
