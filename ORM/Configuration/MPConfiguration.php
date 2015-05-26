<?php

namespace Mediapark\MPDoctrineREpositoryExtensionBundle\ORM\Configuration;

class MPConfiguration extends AbstractMPConfiguration {

  protected $repositoryFactory;

  protected function setRepositoryFactory() {
    $repositoryFactoryClass = $this->getRepositoryFactoryClass();
    $this->repositoryFactory = new $repositoryFactoryClass($this->getRepositoriesResolver());

    return $this->repositoryFactory;
  }

  public function getRepositoryFactory() {
    return is_null($this->repositoryFactory) ? $this->setRepositoryFactory() : $this->repositoryFactory;
  }

  protected function setRepositoriesResolver() {
    $repositoriesResolverClass = $this->getRepositoriesResolverClass();
    $this->repositoriesResolver = new $repositoriesResolverClass();

    return $this->repositoriesResolver;
  }

  public function getRepositoriesResolver() {
    return is_null($this->repositoriesResolver) ? $this->setRepositoriesResolver() : $this->repositoriesResolver;
  }

}