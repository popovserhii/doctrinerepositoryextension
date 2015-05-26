<?php

namespace Mediapark\MPDoctrineREpositoryExtensionBundle\ORM\Repository\EntityRepositories;

use Exception;

class MPEntityRepositories extends AbstractMPEntityRepositories
{
    function __construct($id) {
        $this->setId($id);
    }

    public function getByRepositoryBundle($repositoryBundle = null) {
        return ($this->shouldReturnDefaultRepository($repositoryBundle)) ? 
                $this->getFirstRepository() :
                $this->getRepositoryByBundle($repositoryBundle);
    }

    public function getByRepositoryName($repositoryBundle) {
        return $this->findRepositoryBy($repositoryBundle);
    }

    private function shouldReturnDefaultRepository($repositoryBundle = null) {
        return (is_null($repositoryBundle) && !$this->listEmpty()) ? true : false;
    }

    private function getFirstRepository() {
        return reset($this->list);
    }

    private function getRepositoryByBundle($repositoryBundle) {
        if (isset($this->list[$repositoryBundle])) {
            return $this->list[$repositoryBundle];
        }
        else {
            return null;
            //throw new Exception('Repository at ' . $repositoryBundle . ' not found.');
        }
    }

}