<?php

namespace Nkt\ImageBundle\Entity;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
class Image
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $path;

    public function __construct($type, $path)
    {
        $this->type = $type;
        $this->path = $path;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return (string)$this->getPath();
    }
}
