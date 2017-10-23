<?php

/**
 * This file is created by Matthieu
 * 
 * 10/22/2017 - tinkergotinker@gmail.com
 * 
 */

 namespace Cocorico\CoreBundle\Entity;

 use Cocorico\CoreBundle\Model\BaseListingHowtoWear;
 use Doctrine\ORM\Mapping as ORM;

 /**
  * ListingHowtoWear
  *
  * @ORM\Entity()
  *
  * @ORM\Table(name="listing_listing_howtowear")
  *
  */
  class ListingHowtoWear extends BaseListingHowtoWear
  {
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cocorico\CoreBundle\Entity\Listing")
     * @ORM\JoinColumn(name="listing_id1", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $listingId1;

    /**
     * @ORM\ManyToOne(targetEntity="Cocorico\CoreBundle\Entity\Listing")
     * @ORM\JoinColumn(name="listing_id2", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $listingId2;

    public function __construct() {
        // Initialize collections
        $this->listing_id1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->listing_id2 = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set listing_id1
     *
     * @param  \Cocorico\CoreBundle\Entity\Listing $listing
     * @return ListingHowtoWear
     */
    public function setListingId1(Listing $listing)
    {
        $this->listingId1 = $listing;

        return $this;
    }

    /**
     * Get listingCharacteristicType
     *
     * @return \Cocorico\CoreBundle\Entity\Listing
     */
    public function getListingId1()
    {
        return $this->listingId1;
    }

    /**
     * Set listing_id2
     *
     * @param  \Cocorico\CoreBundle\Entity\Listing $listing
     * @return ListingHowtoWear
     */
    public function setListingId2(Listing $listing)
    {
        $this->listingId2 = $listing;

        return $this;
    }

    /**
     * Get listingCharacteristicType
     *
     * @return \Cocorico\CoreBundle\Entity\Listing
     */
    public function getListingId2()
    {
        return $this->listingId2;
    }
  }