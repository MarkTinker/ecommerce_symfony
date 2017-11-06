<?php

/**
 * This file is created by Matthieu Baillieu
 * 
 * 11/4/2017 - tinkergotinker@gmail.com
 */
namespace Cocorico\CoreBundle\Entity;

use Cocorico\CoreBundle\Model\BaseEditorPick;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EditorPick
 * 
 * @ORM\Entity
 * @ORM\Table(name="editor_pick")
 */
class EditorPick extends BaseEditorPick
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="assert.not_blank")
     * 
     * @ORM\OneToOne(targetEntity="Cocorico\CoreBundle\Entity\Listing")
     * @ORM\JoinColumn(name="listing_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * 
     * @var $listing
     */
    private $listing;
    
    /**
    * Set listing
    * 
    * @param \Cocorico\CoreBundle\Entity\EditorPick $editorpick
    * @return EditorPick
    */
    public function setListing(Listing $listing = null)
    {
        $this->listing = $listing;

        return $this;
    }

    /**
    * Get listing
    * 
    * @return \Cocorico\CoreBundle\Entity\Listing
    */
    public function getListing()
    {
        return $this->listing;
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

    public function __toString()
    {
        return (string)$this->getListing();
    }
}