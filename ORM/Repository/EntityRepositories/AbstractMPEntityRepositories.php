<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Repository\EntityRepositories;

abstract class AbstractMPEntityRepositories
{
  protected $id;
  protected $list;

  //abstract protected function getById($id);
  abstract protected function getByRepositoryName($repositoryName);

  protected function setId($id) {
    $this->id = $id;
  }
  protected function getId() {
    return $this->id;
  }

  public function addRepository($repositoryBundle, $repository) {
    $this->list[$repositoryBundle] = $repository;
  }

  public function removeRepository($repositoryBundle) {
    if ($this->findRepositoryBy($repositoryBundle) !== false) {
      unset($this->list[$repositoryBundle]);
    }
  }

  protected function findRepositoryBy($bundle) {
    return (isset($this->list[$bundle])) ? $this->list[$bundle] : false;
  }

  protected function listEmpty() {
    return (count($this->list) === 0) ? true : false;
  }
}