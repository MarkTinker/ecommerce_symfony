<?php

/**
 * Edited by Mark Brandt 
 * 
 * mwbdevelopment@gmail.com
 * 
 * 10/17/2017
 */

 namespace Cocorico\CoreBundle\Entity;

 use Cocorico\CoreBundle\Model\BaseDesigner;
 use Doctrine\Common\Collections\ArrayCollection;
 use Doctrine\ORM\Mapping as ORM;
 use Gedmo\Mapping\Annotation as Gedmo;
 use Knp\DoctrineBehaviors\Model as ORMBehaviors;
 use Symfony\Component\Validator\Constraints as Assert;

 /**
  * Designer
  *
  * @ORM\Entity
  * @ORM\Table(name="designer")
  */
class Designer extends BaseDesigner
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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