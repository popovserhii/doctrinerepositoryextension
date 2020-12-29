<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Mediapark\MPDoctrineRepositoryExtensionBundle\DependencyInjection\MediaparkMPDoctrineRepositoryExtensionExtension;

class MediaparkMPDoctrineRepositoryExtensionBundle extends Bundle
{
  public function getContainerExtension()
  {
    return new MediaparkMPDoctrineRepositoryExtensionExtension();
  }
}
