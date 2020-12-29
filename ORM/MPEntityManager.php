<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Repository\RepositoryFactory;
use Doctrine\ORM\ORMException;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Repository;
use Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Configuration\InterfaceMPConfiguration;
//use Model\MainBundle\Annotations\RepositoryResolver;

class MPEntityManager extends EntityManager {

    private $repositoryFactory;
    public static $count = 0;

    protected function __construct(Connection $conn, Configuration $config, EventManager $eventManager) {
        parent::__construct($conn, $config, $eventManager);

        $this->setRepositoryFactory($config->getRepositoryFactory());
    }

    public static function customCreate(InterfaceMPConfiguration $MPConfiguration, $conn, Configuration $config, EventManager $eventManager = null) {
        if (!$config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        $config->setRepositoryFactory($MPConfiguration->getRepositoryFactory());

        switch (true) {
            case (is_array($conn)):
                $conn = \Doctrine\DBAL\DriverManager::getConnection(
                    $conn, $config, ($eventManager ?: new EventManager())
                );
                break;

            case ($conn instanceof Connection):
                if ($eventManager !== null && $conn->getEventManager() !== $eventManager) {
                     throw ORMException::mismatchedEventManager();
                }
                break;

            default:
                throw new \InvalidArgumentException("Invalid argument: " . $conn);
        }

        return new MPEntityManager($conn, $config, $conn->getEventManager());
    }

    public function getRepository($entityName, $repositoryBundle = null) {
        return $this->getRepositoryFactory()->getRepository($this, $entityName, $repositoryBundle);
    }

    protected function setRepositoryFactory(RepositoryFactory $repositoryFactory) {
        $this->repositoryFactory = $repositoryFactory;
    }

    protected function getRepositoryFactory() {
        return $this->repositoryFactory;
    }

    public function get($entityName) {
        /*if (strpos($className, ':') !== false) {
            list($namespaceAlias, $simpleClassName) = explode(':', $className);
            var_dump($namespaceAlias);
            var_dump($simpleClassName);
            die()
            //$realClassName = $this->getFqcnFromAlias($namespaceAlias, $simpleClassName);
        }*/

        $this->entityResolver->getRepositoryByEntity($entityName);
        die();

        var_dump("SHIT");
        var_dump($entityName);
        die();
        $repositoryClass = $this->resolveByEntity($entityName);

        $this->entityResolver = new RepositoryResolver($repositoryClass);
        var_dump($this->entityResolver);
        die();

        $er = $this->container->get($entity_name);
        $this->metaData = $this->getClassMetadata($er->getEntityName());        
        $er->init($this->em, $this->metaData);
        return $er;
    }

    private function resolveByEntity($entityName) {
        $entityName = ltrim($entityName, '\\');
        var_dump($entityName);
        die();
    }

}
