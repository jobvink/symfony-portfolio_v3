<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 14-12-17
 * Time: 21:30
 */

namespace App\Service;


use App\Entity\DeleterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class Deleter
{
    private $router = null;
    private $user = null;

    public function __construct(UrlGeneratorInterface $router, Security $security)
    {
        $this->router = $router;
        $this->user = $security->getUser();
    }

    public function target(DeleterInterface $entity)
    {
        if (!$this->user) return null;
        if (!in_array('ROLE_EDITOR', $this->user->getRoles())) return null;

        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        return 'id="' . $entity_name . '_' . $id . '"';
    }

    public function button(DeleterInterface $entity)
    {
        if (!$this->user) return null;
        if (!in_array('ROLE_EDITOR', $this->user->getRoles())) return null;

        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        $target = $entity_name . '_' . $id;

        $url = $this->router->generate($entity->getEntityName() . '_delete', ['id' => $entity->getId()]);

        return '<div class="deletable" data-target="' . $target . '" data-url="' . $url . '"><i class="fa fa-times delete-icon"></i></div>';
    }
}