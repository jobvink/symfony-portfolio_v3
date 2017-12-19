<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 14-12-17
 * Time: 20:59
 */

namespace App\Service;


use App\Entity\updaterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class Updater
{
    private $router = null;
    private $user = null;

    public function __construct(UrlGeneratorInterface $router, Security $security)
    {
        $this->router = $router;
        $this->user = $security->getUser();
    }

    public function make(UpdaterInterface $entity, $field)
    {

        if (!$this->user) return null;
        if (!in_array('ROLE_EDITOR', $this->user->getRoles())) return null;

        $url = $this->router->generate($entity->getEntityName() . '_update', ['id' => $entity->getId()]);

        return 'class="editable" data-type="' . $field . '" data-url="' . $url . '"';
    }
}