<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Configuration;

abstract class AbstractMPConfiguration implements InterfaceMPConfiguration {

  protected $ORMConfiguration;
  protected $repositoryFactory;
  protected $repositoriesResolver;

  abstract protected function setRepositoryFactory();
  abstract function getRepositoryFactory();

  abstract function getRepositoriesResolver();
  abstract protected function setRepositoriesResolver();

  public function setORMConfiguration(array $configuration) {
    $this->ORMConfiguration = $configuration;
  }
  
  protected function getORMConfiguration() {
    return $this->ORMConfiguration;
  }

  protected function getRepositoryFactoryConfiguration() {
    return $this->ORMConfiguration['repository_factory'];
  }

  protected function getRepositoryFactoryClass() {
    return $this->getRepositoryFactoryConfiguration()['class'];
  }

  protected function getRepositoriesResolverClass() {
    return $this->getRepositoryFactoryConfiguration()['repositories_resolver']['class'];
  }

}