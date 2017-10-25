<?php

/**
 * This file is created by Matthieu
 * 
 * 10/23/2017 - tinkergotinker@gmail.com
 */

 namespace Cocorico\UserBundle\Entity;

 use Cocorico\UserBundle\Entity\User;
 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserFavoriteImage
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="user_favorite_image", indexes={
 *     @ORM\Index(name="position_u_idx", columns={"position"})   
 * })
 * 
 */
class UserFavoriteImage
{

    const IMAGE_DEFAULT = "default-user.png";
    const IMAGE_FOLDER = "/uploads/users/fav_images/";

    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     *
     * @ORM\Column(type="string", length=255, name="name", nullable=false)
     *
     * @var string $name
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="smallint", nullable=false)
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="favorite_images")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets name.
     *
     * @param $name
     * @return $this
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
     * Set position
     *
     * @param  boolean $position
     * @return UserFavoriteImage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return boolean
     */
    public function getPosition()
    {
        return $this->position;
    }


    /**
     * Set user
     *
     * @param  \Cocorico\UserBundle\Entity\User $user
     * @return UserFavoriteImage
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cocorico\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getWebPath()
    {
        return null === $this->name ? null : self::IMAGE_FOLDER . $this->name;
    }
}
  