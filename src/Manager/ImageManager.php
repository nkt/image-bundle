<?php

namespace Nkt\ImageBundle\Manager;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Nkt\ImageBundle\Entity\Image;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
class ImageManager
{
    /**
     * @var string
     */
    protected $uploadDir;
    /**
     * @var string
     */
    protected $tempDir;
    /**
     * @var array
     */
    protected $types = array();
    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @param string $uploadDir
     */
    public function __construct($uploadDir)
    {
        $this->fs = new Filesystem();
        $this->uploadDir = $uploadDir;
        $this->tempDir = $uploadDir . '/tmp';
    }

    /**
     * @param string $type
     * @param array  $options
     *
     * @return static
     */
    public function addType($type, array $options)
    {
        $this->types[$type] = $options;

        return $this;
    }

    /**
     * @param string       $type
     * @param UploadedFile $uploadedFile
     *
     * @throws \InvalidArgumentException
     * @return Image
     */
    public function uploadImage($type, UploadedFile $uploadedFile)
    {
        if (!isset($this->types[$type])) {
            throw new \InvalidArgumentException('The type "' . $type . '" is not found');
        }
        $options = $this->types[$type];

        $name = sha1(uniqid($uploadedFile->getClientOriginalName(), true)) . '.' . $options['extension'];
        $path = '/' . substr($name, 0, 2) . '/' . substr($name, 2, 2) . '/';
        $fullPath = $this->uploadDir . $path;

        $file = $uploadedFile->move($this->tempDir);
        $imagick = new \Imagick($file->getPathname());
        $this->fs->remove($file);

        $this->checkSizes($imagick->getImageLength(), $imagick->getImageHeight(), $options);
        $this->fs->mkdir($fullPath, 0740);
        $imagick->writeImage($fullPath . $name);

        return new Image($type, $path . $name);
    }

    protected function checkSizes($width, $height, array $options)
    {
        if ($width < $options['min_width']) {
            throw new \InvalidArgumentException('Image width less than minimum');
        }
        if ($height < $options['min_height']) {
            throw new \InvalidArgumentException('Image height less than minimum');
        }
        if ($options['max_width'] !== 0 && $width > $options['max_width']) {
            throw new \InvalidArgumentException('Image width more than maximum');
        }
        if ($options['max_height'] !== 0 && $height > $options['max_height']) {
            throw new \InvalidArgumentException('Image height more than maximum');
        }
    }
} 
