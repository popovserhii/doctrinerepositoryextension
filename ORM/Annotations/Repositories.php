<?php

namespace Mediapark\MPDoctrineREpositoryExtensionBundle\ORM\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
* @Annotation
* @Target("CLASS")
*/
final class Repositories
{
  public $classes;
}