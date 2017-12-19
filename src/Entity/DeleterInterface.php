<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 14-12-17
 * Time: 21:30
 */

namespace App\Entity;


interface DeleterInterface
{
    public function getId();
    public function getEntityName();
}