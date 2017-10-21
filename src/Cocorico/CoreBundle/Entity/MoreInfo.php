<?php
/**
 * This file is Created by Matthieu
 * 
 * tinkergotinker@gmail.com
 * 
 * 10/19/2017
 */

 namespace Cocorico\CoreBundle\Entity;

 use Cocorico\CoreBundle\Model\BaseMoreInfo;
 use Doctrine\ORM\Mapping as ORM;
 use Gedmo\Mapping\Annotation as Gedmo;
 use Knp\DoctrineBehaviors\Model as ORMBehaviors;
 use Symfony\Component\Validator\Constraints as Assert;

 /**
  * MoreInfo
  *
  * @ORM\Entity
  * @ORM\HasLifecycleCallbacks
  * @ORM\Table(name="more_info")
  */
  class MoreInfo extends BaseMoreInfo
  {
    use ORMBehaviors\Timestampable\Timestampable;    

    /**
     * 
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)     
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer
     */
    private $id;

    public function __construct()
    {
        $this->published = false;
        $this->updated = new \DateTime("now");
    }

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
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->filename = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Lifecycle callback to upload the file to the server
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function lifecycleFileUpload() {
        $this->upload();
    }
}