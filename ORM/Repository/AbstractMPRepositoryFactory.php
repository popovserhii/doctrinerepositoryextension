<?php

namespace Mediapark\MPDoctrineREpositoryExtensionBundle\ORM\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository;
use Mediapark\MPDoctrineREpositoryExtensionBundle\ORM\Repository\EntityRepositories\IntefaceMPEntityRepositories;

abstract class AbstractMPRepositoryFactory implements InterfaceMPRepositoryFactory
{
    protected $repositoryList = array();
    protected $repositoriesResolver;


    abstract protected function addRepository($entityName, $repositoryBundle, $repository);
    //abstract protected function removeEntityRepository($repositoryNameSpace);
    /*abstract function repositoryExists($entityName);
    abstract function addRepository($entityName);
    abstract function removeRepository($entityName);
    abstract function getRepositoryBy($entityName);*/
}