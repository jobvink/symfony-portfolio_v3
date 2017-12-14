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

class AttachementUpdater
{
    private $router = null;

    public function __construct(UrlGeneratorInterface $router) {

        $this->router = $router;

    }

    public function make(UpdaterInterface $entity) {

        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        $url = $this->router->generate($entity_name . '_update', ['id' => $entity->getId()]);

        return 'class="image-editable" data-input="'.$entity_name.'_'.$id.'_input" data-type="attachment" data-url="' . $url . '"';

    }

    public function input(UpdaterInterface $entity) {

        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        return '<input type="file" class="u-hidden" id="'.$entity_name.'_'.$id.'_input">';
    }

}