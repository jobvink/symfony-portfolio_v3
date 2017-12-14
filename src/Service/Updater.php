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

class Updater
{
    private $router = null;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function make(UpdaterInterface $entity, $field)
    {

        $class = get_class($entity);
        $url = $this->router->generate($entity->getEntityName() . '_update', ['id' => $entity->getId()]);

        return 'class="editable" data-type="' . $field . '" data-url="' . $url . '"';
    }
}