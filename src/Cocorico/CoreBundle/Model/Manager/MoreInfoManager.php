<?php
/**
 * This file is created and modified by Matthieu
 * 
 * 10/20/2017 mwbdevelopment@gmail.com
 */

namespace Cocorico\CoreBundle\Model\Manager;

use Cocorico\CoreBundle\Entity\MoreInfo;
use Doctrine\ORM\EntityManager;

class MoreInfoManager
{
    protected $em;
    
    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMoreinfos()
    {
        //$moreinfos = $this->getRepository()->findAll();
        //$moreinfos = $this->em->getRepository(MoreInfo::class)->findAll();

        //$repository = $this->em->getRepository(MoreInfo::class);
        $repository = $this->getRepository();
        $query = $repository->createQueryBuilder('p')
            ->where('p.published = true')
            ->getQuery();
        $moreinfos = $query->getResult();
        
        return $moreinfos;
    }

    /**
     *
     * @return BookingBankWireRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CocoricoCoreBundle:MoreInfo');
    }
}