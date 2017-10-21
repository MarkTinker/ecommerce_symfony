<?php

/**
 * This file is created by Mark Brandt
 * 
 * 10/19/2017 - mwbdevelopment@gmail.com
 * 
 */

 namespace Cocorico\CoreBundle\Model;

 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\Validator\Constraints as Assert;
 use Symfony\Component\HttpFoundation\File\UploadedFile;
 
 /**
  * BaseMoreInfo
  * @ORM\MappedSuperclass
  */

abstract class BaseMoreInfo
{
    const SERVER_PATH_TO_IMAGE_FOLDER = '/images/upload';
    /**
     * 
     * @ORM\Column(name="published", type="boolean", nullable=true)
     * 
     * @var boolean
     */
    protected $published;

    /**
     * 
     * @ORM\Column(name="url", type="string", length=2000, nullable=true)
     * 
     * @var string
     */
    protected $url;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * @Assert\Length(
     *      min = "3",
     *      max = "100",
     *      minMessage = "assert.min_length {{ limit }}",
     *      maxMessage = "assert.max_length {{ limit }}"
     * )
     * 
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     * 
     * @var string
     */
    protected $title;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     * 
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="filename", type="string", length=100, nullable=true)
     * 
     * @var string
     */
    protected $filename;
    
    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * Get published
     * 
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return PageTranslation
     */
    public function setTitle($title)
    {
        $this->title = ucfirst($title);

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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return BaseMoreInfo
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
     * Set filename
     *
     * @param  string $filename
     * @return BaseMoreInfo
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
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
        return 'images/upload';
    }
}