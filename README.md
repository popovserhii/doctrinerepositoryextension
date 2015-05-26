<a name="configuration"></a>

### Configuration

```yaml
#config.yml
#at the beginning of config.yml import the service.yml file.

imports:
    ...
    - { resource: "@MediaparkMPDoctrineRepositoryExtensionBundle/Resources/config/services.yml" }

mp_doctrine: 
    doctrine: 
        orm: 
            repository_factory: 
                class: %model.doctrine.orm.default_repository_factory.class% 
                repositories_resolver: 
                    class: %model.doctrine.orm.repositories_resolver.class%
```

### Usage

STEP 1:
--------
Import the repositories annotation and define an annotation of which repositories of entity should be used and where is is located.

```php
// Acme/DemoBundle/Entity/User.php

namespace ...

use ...
use Mediapark\MPDoctrineRepositoryExtensionBundle\ORM\Annotations\Repositories;

/**
 * ... (other annotations)
 * @Repositories(classes={"Backend\UserBundle\Entity\UserRepository", "Api\UserBundle\Entity\UserRepository"})
 */
class User {
...  

```

STEP 2:
--------
Use the specified repository in the controller.

```php
// Acme/DemoBundle/Controller/IndexController.php

class ... {
  ....
  public function indexAction(Request $request) {
    ...
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('AcmeDemoBundle:User', 'BackendUserBundle');
    ...
  }
  public function secondIndexAction(Request $request) {
    ...
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('AcmeDemoBundle:User');
    ...
  }
  ....
}

```