<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\ORM\Repository\DefaultRepositoryFactory;
use Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Annotations\InterfaceMPRepositoriesResolver;
use Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Repository\EntityRepositories\MPEntityRepositories;

class MPDefaultRepositoryFactory extends AbstractMPRepositoryFactory
{

    function __construct(InterfaceMPRepositoriesResolver $repositoriesResolver) {
        $this->repositoriesResolver = $repositoriesResolver;
    }

    public function getRepository(EntityManagerInterface $entityManager, $entityName, $repositoryBundle = null)
    {
        $entityName = ltrim($entityName, '\\');

        if ($this->repositoryExists($entityName, $repositoryBundle)) {
            return $this->repositoryList[$entityName]->getByRepositoryBundle($repositoryBundle);
        }

        $repository = $this->createRepository($entityManager, $entityName, $repositoryBundle);


        /*$entityRepositories = new EntityRepositories($entityName);
        $entityRepositories->addRepository($repository);
        $this->repositoryList[$entityName] = new EntityRepositories($entityName);
        $this->repositoryList[$entityName] = $repository;*/

        return $repository;
    }

    protected function repositoryExists($entityName, $repositoryBundle) {
        return ($this->repositoriesListByEntityNameExists($entityName) &&
                 false === is_null($this->repositoryList[$entityName]->getByRepositoryBundle($repositoryBundle)) && 
                 false === is_null($repositoryBundle)) ?
                true :
                false;
    }

    protected function repositoriesListByEntityNameExists($entityName) {
        return (isset($this->repositoryList[$entityName])) ? true : false;
    }

    /**
     * Create a new repository instance for an entity class.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager The EntityManager instance.
     * @param string                               $entityName    The name of the entity.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function createRepository(EntityManagerInterface $entityManager, $entityName, $repositoryBundle = null)
    {
        $metadata = $entityManager->getClassMetadata($entityName);

        $repositoryClassName = null;
        $repositoryNamespace = null;
        if (is_null($repositoryBundle)) {
            $repositoryNamespace = $metadata->namespace;
            $repositoryClassName = $metadata->customRepositoryClassName;
        }
        else {
            $repositoryNamespace = $entityManager->getConfiguration()->getEntityNamespace($repositoryBundle);
            $repositoryClassName = $this->repositoriesResolver->resolve($metadata->name, $repositoryNamespace);
        }

        if ($repositoryClassName === null) {
            $configuration       = $entityManager->getConfiguration();
            $repositoryClassName = $configuration->getDefaultRepositoryClassName();
        }

        $repository = new $repositoryClassName($entityManager, $metadata);
        $this->addRepository($entityName, $repositoryBundle, $repository);

        return $repository;
    }

    protected function addRepository($entityName, $repositoryBundle, $repository) {
        if ($this->repositoriesListByEntityNameExists($entityName)) {
            $repositoriesList = $this->getRepositoriesListByEntity($entityName);
            $repositoriesList->addRepository($repositoryBundle, $repository);
        }
        else {
            $entityRepositories = new MPEntityRepositories($entityName);
            $entityRepositories->addRepository($repositoryBundle, $repository);
            $this->addRepositoriesList($entityName, $entityRepositories);
            //$repositoriesList[$entityName] = $entityRepositories;
        }
    }

    protected function addRepositoriesList($entityName, $entityRepositories) {
        $this->repositoryList[$entityName] = $entityRepositories;
    }

    protected function getRepositoriesListByEntity($entityName) {
        return $this->repositoryList[$entityName];
    }

    protected function getRepositoryList() {
        return $this->repositoryList;
    }

}