<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 14-12-17
 * Time: 21:21
 */

namespace App\Entity;

interface UpdaterInterface
{
    public function getEntityName();
    public function getId();
}