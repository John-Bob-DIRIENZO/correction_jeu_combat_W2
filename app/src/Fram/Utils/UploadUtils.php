<?php

namespace App\Fram\Utils;

use App\Entity\Image;
use App\Fram\Entity\UploadedFile;
use App\Fram\HTTPFoundation\HTTPRequest;

class UploadUtils
{
    const UPLOADED_PUBLIC_IMAGES = "/images/uploads/";

    /**
     * Returns the filename of the image on the FileSystem
     * use 'UPLOADED_PUBLIC_IMAGES' const to get the full filePath
     * @param string $name
     * @return false|Image
     */
    public static function uploadImage(string $name)
    {
        $HTTPRequest = new HTTPRequest();
        $image = $HTTPRequest->getFile($name);

        if (!$image) {
            return false;
        }

        $uploadedFile = new UploadedFile($image['name'], $image['type'], $image['tmp_name'], $image['size']);

        if (!$uploadedFile->isImage()) {
            return false;
        }

        $source = fopen($uploadedFile->getTempPath(), 'r');
        $uploadDest = dirname(__DIR__, 3) . '/public' . self::UPLOADED_PUBLIC_IMAGES . $uploadedFile->getSafeName();
        $dest = fopen($uploadDest, 'wb');
        stream_copy_to_stream($source, $dest);
        fclose($source);
        fclose($dest);

        $image = new Image();
        $image->setOriginalFileName($uploadedFile->getFileName())
            ->setSlugName($uploadedFile->getSafeName())
            ->setRealMimeType($uploadedFile->getRealMimeType())
            ->setSize($uploadedFile->getSize());

        return $image;
    }
}