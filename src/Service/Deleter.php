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

class Deleter
{
    private $router = null;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;

    }

    public function target(DeleterInterface $entity)
    {
        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        return 'id="' . $entity_name . '_' . $id . '"';
    }

    public function button(DeleterInterface $entity)
    {
        $entity_name = $entity->getEntityName();
        $id = $entity->getId();

        $target = $entity_name . '_' . $id;

        $url = $this->router->generate($entity->getEntityName() . '_delete', ['id' => $entity->getId()]);

        return '<div class="deletable" data-target="' . $target . '" data-url="' . $url . '"><i class="fa fa-times delete-icon"></i></div>';
    }
}