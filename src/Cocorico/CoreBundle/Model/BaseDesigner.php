<?php

/*
 * This file is created by Matthieu Baillieu
 *
 * 10/25/2017 - tinkergotinker@gmail.com
 */

namespace Cocorico\CoreBundle\Model;

use Cocorico\CoreBundle\Entity\Designer;
use Cocorico\CoreBundle\Validator\Constraints as CocoricoAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BaseDesigner 
 * 
 * @ORM\MappedSuperclass
 */
abstract class BaseDesigner
{
    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * 
     * @ORM\Column(name="name", type="text", nullable=false)
     * 
     * @var string
     */
    protected $name;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * 
     * @ORM\Column(name="favorite", type="boolean", nullable=false)
     * 
     * @var boolean
     */
    protected $favorite = false;

    /**
     * Set name
     *
     * @param  string $name
     * @return Designer
    */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
    * Get name
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set favorite
     * 
     * @param boolean $favorite
     * @return Designer
    */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     * 
     * @return boolean
     */
    public function getFavorite()
    {
        return $this->favorite;
    }
}