<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Controller\Frontend;

use Cocorico\CoreBundle\Repository\ListingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 *
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="cocorico_home")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        /** @var ListingRepository $listingRepository */
        $listingRepository = $this->getDoctrine()->getRepository('CocoricoCoreBundle:Listing');
        $listings = $listingRepository->findByHighestRanking(6, $request->getLocale());

        return $this->render(
            'CocoricoCoreBundle:Frontend\Home:index.html.twig',
            array(
                'listings' => $listings
            )
        );
    }

    public function menuAction(Request $request)
    {
        $this->getDoctrine()->getManager()->clear();

        $homemenuRepository = $this->getDoctrine()->getRepository('CocoricoCoreBundle:HomeMenu');
        $homemenus = $homemenuRepository->findAll();

        $categoryRepository = $this->getDoctrine()->getRepository('CocoricoCoreBundle:ListingCategory');
        $categories = $categoryRepository->findAll();
        
        $designerRepository = $this->getDoctrine()->getRepository('CocoricoCoreBundle:Designer');

        $designers = $designerRepository->findBy(array(), array('name'=>'asc'));
        //$designers = $designerRepository->findAll();
        return $this->render(
            'CocoricoCoreBundle:Frontend\Home:menu.html.twig',
            array(
                'homemenus' => $homemenus,
                'categories' => $categories,
                'designers' => $designers,
            )
        );
    }
}
