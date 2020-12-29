<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;

class RepositoriesResolver implements InterfaceMPRepositoriesResolver
{

  private $repositoriesClasses;
  private $reader;

  function __construct() {
    $this->reader = new AnnotationReader();
  }

  public function resolve($entityClass, $bundle) {
    $entityReflectionClass = new \ReflectionClass($entityClass);
    $annotations = $this->reader->getClassAnnotations($entityReflectionClass);

    $this->findRepositoriesListAnnotation($annotations);

    $repositoryClass = $this->repositoryExistsIn($bundle);

    if ($repositoryClass !== false) {
      return $repositoryClass;
    }

    return null;
  }

  private function findRepositoriesListAnnotation($annotations) {
    foreach ($annotations as $annotation) {
      if ($annotation instanceof Repositories) {
        $this->setRepositoriesClasses($annotation->classes);
        break;
      }
    }

    return $this->getRepositoriesClasses();
  }

  private function getRepositoriesClasses() {
    return $this->repositoriesClasses;
  }

  private function repositoryExistsIn($bundle) {
    foreach ($this->getRepositoriesClasses() as $repositoryClass) {
      if (substr($repositoryClass, 0, strlen($bundle)) === $bundle) {
        return $repositoryClass;
      }
    }
    return false;
  }

  private function setRepositoriesClasses($repositoriesClasses) {
    $this->repositoriesClasses = $repositoriesClasses;
  }
}