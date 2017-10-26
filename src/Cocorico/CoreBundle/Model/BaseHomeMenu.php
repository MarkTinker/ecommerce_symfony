<?php

/**
 * This file is created by Mattheiu Bailleiu
 * 
 * 10/25/2017 - tinkergotinker@gmail.com
 */

 namespace Cocorico\CoreBundle\Model;

 use Cocorico\CoreBundel\Entity\HomeMenu;
 use Doctrine\ORM\Mapping as ORM;
 use Gedmo\Mapping\Annotation as Gedmo;
 use Knp\DoctrineBehaviors\Model as ORMBehaviors;
 use Symfony\Component\Validator\Constraints as Assert;
 use Symfony\Component\HttpFoundation\File\UploadedFile;

 /**
  * BaseHomeMenu
  * @ORM\MappedSuperclass
  */
abstract class BaseHomeMenu
{
    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * 
     * @ORM\Column(name="name", type="string", nullable=false)
     * 
     * @var string
     */
    protected $name;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * 
     * @ORM\Column(name="title", type="string", nullable=true)
     * 
     * @var string
     */
    protected $title;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * 
     * @ORM\COlumn(name="description", type="string", nullable=true)
     * 
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="imgname", type="string", length=255, nullable=true)
     * 
     * @var string imgname
     */
    protected $imgname;

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * Set name
     *
     * @param  string $name
     * @return HomeMenu
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
     * Set title
     *
     * @param  string $title
     * @return HomeMenu
    */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
    * Get title
    *
    * @return string
    */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return HomeMenu
    */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
    * Get description
    *
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imgname
     *
     * @param  string $imgname
     * @return HomeMenu
    */
    public function setImgname($imgname)
    {
        $this->imgname = $imgname;

        return $this;
    }

    /**
    * Get imgname
    *
    * @return string
    */
    public function getImgname()
    {
        return $this->imgname;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated() {
        $this->setUpdatedAt(new \DateTime("now"));
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'images/upload/menuimgs';
    }
}