<?php

namespace App\Entity;

Interface PortfolioInterface {
    public function getAttachment();
    public function setAttachment($attacehemt);
    public function getAttachmentName();
}