<?php

namespace App\Entity;

use App\Fram\BaseClasses\BaseEntity;
use App\Fram\Utils\UploadUtils;

class Image extends BaseEntity
{
    private int $id;
    private string $originalFileName;
    private string $slugName;
    private string $realMimeType;
    private int $size;

    /**
     * @return string
     */
    public function getOriginalFileName(): string
    {
        return $this->originalFileName;
    }

    /**
     * @param string $originalFileName
     * @return Image
     */
    public function setOriginalFileName(string $originalFileName): Image
    {
        $this->originalFileName = $originalFileName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlugName(): string
    {
        return $this->slugName;
    }

    /**
     * @param string $slugName
     * @return Image
     */
    public function setSlugName(string $slugName): Image
    {
        $this->slugName = $slugName;
        return $this;
    }

    /**
     * @return string
     */
    public function getRealMimeType(): string
    {
        return $this->realMimeType;
    }

    /**
     * @param string $realMimeType
     * @return Image
     */
    public function setRealMimeType(string $realMimeType): Image
    {
        $this->realMimeType = $realMimeType;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return Image
     */
    public function setSize(int $size): Image
    {
        $this->size = $size;
        return $this;
    }

    public function getPath(): string
    {
        return UploadUtils::UPLOADED_PUBLIC_IMAGES . $this->getSlugName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Image
     */
    public function setId(int $id): Image
    {
        $this->id = $id;
        return $this;
    }
}