<?php

namespace App\Entity;

Interface PortfolioInterface {
    public function getId();
    public function getAttachment();
    public function setAttachment($attacehemt);
    public function getAttachmentName();
}