<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 14-12-17
 * Time: 21:56
 */

namespace App\Service;


use App\Entity\PortfolioInterface;
use App\Entity\UpdaterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AttachementUpdater
{
    private $router = null;
    private $user = null;

    public function __construct(UrlGeneratorInterface $router, Security $security) {

        $this->router = $router;
        $this->user = $security->getUser();
    }

    public function make(UpdaterInterface $entity) {

        if (!$this->user) return null;
        if (!in_array('ROLE_EDITOR', $this->user->getRoles())) return null;

        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        $url = $this->router->generate($entity_name . '_update', ['id' => $entity->getId()]);

        return 'class="image-editable" data-input="'.$entity_name.'_'.$id.'_input" data-type="attachment" data-url="' . $url . '"';

    }

    public function input(UpdaterInterface $entity) {

        if (!$this->user) return null;
        if (!in_array('ROLE_EDITOR', $this->user->getRoles())) return null;

        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        return '<input type="file" class="u-hidden" id="'.$entity_name.'_'.$id.'_input">';
    }

}