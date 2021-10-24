<?php

namespace App\Controller;

use App\Fram\BaseClasses\BaseController;
use App\Fram\Utils\DIC;
use App\Fram\Utils\UploadUtils;
use App\Manager\ImageManager;

class ApiController extends BaseController
{
    public function executeUploadImage()
    {
        $image = UploadUtils::uploadImage('image');

        $manager = DIC::autowire('ImageManager');
        /** @var $manager ImageManager */
        $savedImage = $manager->saveImage($image);

        $this->render(
            'Votre Image',
            [
                'image' => $savedImage->getPath()
            ],
            'Frontend/image'
        );
    }
}