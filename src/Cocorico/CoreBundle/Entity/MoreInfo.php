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
  *
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


  }