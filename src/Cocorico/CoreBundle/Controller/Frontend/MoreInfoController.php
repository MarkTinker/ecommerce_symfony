<?php
/**
 * This file is created by Matthieu
 * 
 * 10/20/2017 - mwbdevelopment@gmail.com
 */
namespace Cocorico\CoreBundle\Controller\Frontend;

use Cocorico\CoreBundle\Entity\MoreInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Moreinfo frontend controller
 * 
 * @Route("/moreinfo")
 */
class MoreInfoController extends Controller
{
    /**
     * Display moreinfos
     * 
     * @param Request $request
     * 
     * @return \Symfon\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $moreinfos = $this->get('cocorico.moreinfo.manager')->getMoreInfos();

        return $this->render(
            'CocoricoCoreBundle:Frontend/Listing:moreinfo.html.twig',
            array(
                'moreinfos' => $moreinfos
            )
        );
    }
}