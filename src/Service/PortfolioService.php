<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 05-11-17
 * Time: 20:26
 */

namespace App\Service;


use App\Entity\PortfolioInterface;
use ErrorException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PortfolioService
{

    public function storeAjaxFile(PortfolioInterface $entity, $data, $basepath) {
        $name = $entity->getAttachmentName();

        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $fileExtension = explode('/', $type)[1];

        if (strpos( $fileExtension, 'xml') !== false) {
            $fileExtension = explode('+', $fileExtension)[0];
        }

        $fileName = md5(uniqid()).'.'.$fileExtension;

        try {
            if (file_exists($basepath . $name)) {
                unlink($basepath . $name);
            }
        } catch (ErrorException $exception) {

        }

        if (!file_exists($basepath)) {
            mkdir($basepath, 0777, true);
        }
        // Verplaats het bestand naar de map waar de afbeeldingen opgeslagen worden
        file_put_contents($basepath . '/' . $fileName, $data);

        $entity->setAttachment($fileName);
    }
    
    public function storeFile($file, $basepath) {
        // $file slaat de geuploadde afbeelding op
        /** @var UploadedFile $file */


        $fileExtension = $file->guessExtension();

        if ($fileExtension == null) {
            $filetype = $file->getMimeType();
            $filetype = explode('/', $filetype)[1];
            $fileExtension = $filetype;
        }

        // Generate a unique name for the file before saving it
        $fileName = md5(uniqid()).'.'.$fileExtension;

        // Move the file to the directory where brochures are stored
        $file->move(
            $basepath,
            $fileName
        );

        // Update the 'brochure' property to store the PDF file name
        // instead of its contents
        return $fileName;
    }
    
}