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

use Cocorico\CoreBundle\Entity\ListingImage;
use Cocorico\CoreBundle\Event\ListingSearchActionEvent;
use Cocorico\CoreBundle\Event\ListingSearchEvents;
use Cocorico\CoreBundle\Model\ListingSearchRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListingSearchController extends Controller
{
    /**
     * Listings search result.
     *
     * @Route("/listing/search_result", name="cocorico_listing_search_result")
     * @Method("GET")
     *
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $markers = array();
        $resultsIterator = new \ArrayIterator();
        $nbResults = 0;
        
        /** @var ListingSearchRequest $listingSearchRequest */        
        $listingSearchRequest = $this->get('cocorico.listing_search_request');
        $form = $this->createSearchResultForm($listingSearchRequest);

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $listingSearchRequest = $form->getData();

            $results = $this->get("cocorico.listing_search.manager")->search(
                $listingSearchRequest,
                $request->getLocale()
            );
            $nbResults = $results->count();
            $resultsIterator = $results->getIterator();
            $markers = $this->getMarkers($request, $results, $resultsIterator);

            //Persist similar listings id
            $listingSearchRequest->setSimilarListings(array_column($markers, 'id'));

            //Persist listing search request in session
            $this->get('session')->set('listing_search_request', $listingSearchRequest);

        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    /** @Ignore */
                    $this->get('translator')->trans($error->getMessage(), $error->getMessageParameters(), 'cocorico')
                );
            }
        }

        //Breadcrumbs
        $breadcrumbs = $this->get('cocorico.breadcrumbs_manager');
        $breadcrumbs->addListingResultItems($this->get('request_stack')->getCurrentRequest(), $listingSearchRequest);

        //Add params to view through event listener
        $event = new ListingSearchActionEvent($request);
        $this->get('event_dispatcher')->dispatch(ListingSearchEvents::LISTING_SEARCH_ACTION, $event);
        $extraViewParams = $event->getExtraViewParams();

        return $this->render(
            '@CocoricoCore/Frontend/ListingResult/result.html.twig',
            array_merge(
                array(
                    'results' => $resultsIterator,
                    'nb_results' => $nbResults,
                    'markers' => $markers,
                    'listing_search_request' => $listingSearchRequest,
                    'pagination' => array(
                        'page' => $listingSearchRequest->getPage(),
                        'pages_count' => ceil($nbResults / $listingSearchRequest->getMaxPerPage()),
                        'route' => $request->get('_route'),
                        'route_params' => $request->query->all()
                    ),
                ),
                $extraViewParams
            )
        );

    }

    /**
     * Custom Search Action
     */
    public function customSearchAction(Request $request, $listingSearchRequest)
    {
        $markers = array();
        $resultsIterator = new \ArrayIterator();
        $nbResults = 0;

        $form = $this->createSearchResultForm($listingSearchRequest);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $listingSearchRequest = $form->getData();

            $results = $this->get("cocorico.listing_search.manager")->search(
                $listingSearchRequest,
                $request->getLocale()
            );
            $nbResults = $results->count();
            $resultsIterator = $results->getIterator();
            $markers = $this->getMarkers($request, $results, $resultsIterator);

            //Persist similar listings id
            $listingSearchRequest->setSimilarListings(array_column($markers, 'id'));

            //Persist listing search request in session
            $this->get('session')->set('listing_search_request', $listingSearchRequest);

        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    /** @Ignore */
                    $this->get('translator')->trans($error->getMessage(), $error->getMessageParameters(), 'cocorico')
                );
            }
        }

        //Breadcrumbs
        $breadcrumbs = $this->get('cocorico.breadcrumbs_manager');
        $breadcrumbs->addListingResultItems($this->get('request_stack')->getCurrentRequest(), $listingSearchRequest);

        //Add params to view through event listener
        $event = new ListingSearchActionEvent($request);
        $this->get('event_dispatcher')->dispatch(ListingSearchEvents::LISTING_SEARCH_ACTION, $event);
        $extraViewParams = $event->getExtraViewParams();

        return $this->render(
            '@CocoricoCore/Frontend/ListingResult/result.html.twig',
            array_merge(
                array(
                    'results' => $resultsIterator,
                    'nb_results' => $nbResults,
                    'markers' => $markers,
                    'listing_search_request' => $listingSearchRequest,
                    'pagination' => array(
                        'page' => $listingSearchRequest->getPage(),
                        'pages_count' => ceil($nbResults / $listingSearchRequest->getMaxPerPage()),
                        'route' => $request->get('_route'),
                        'route_params' => $request->query->all()
                    ),
                ),
                $extraViewParams
            )
        );
        
    }

    /**
     * Listings search result added 1week before.
     *
     * @Route("/listing/week", name="cocorico_listing_search_result_week")
     * @Method("GET")
     *
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchWeekAction(Request $request)
    {
        $date = date('Y-m-d', strtotime('-7 days'));
        $request->query->set('createdAfter', $date);
        $request->query->set('page', '1');

        $listingSearchRequest = $this->get('cocorico.listing_search_request');

        $response = $this->forward('CocoricoCoreBundle:Frontend/ListingSearch:customSearch',
            array(
                'request' => $request,
                'listingSearchRequest' => $listingSearchRequest
            )
        );
        return $response;
    }
    /**
     * Listing search result added 1month before
     * 
     * @Route("/listing/month", name="cocorico_listing_search_result_month")
     * @Method("GET")
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchMonthAction(Request $request)
    {
        //$date = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
        $date = date('Y-m-d', strtotime('-1 month'));

        $request->query->set('createdAfter', $date);
        $request->query->set('page', '1');

        $listingSearchRequest = $this->get('cocorico.listing_search_request');

        $response = $this->forward('CocoricoCoreBundle:Frontend/ListingSearch:customSearch',
            array(
                'request' => $request,
                'listingSearchRequest' => $listingSearchRequest
            )
        );
        return $response;
    }

    /**
     * @param  ListingSearchRequest $listingSearchRequest
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createSearchResultForm(ListingSearchRequest $listingSearchRequest)
    {
        $form = $this->get('form.factory')->createNamed(
            '',
            'listing_search_result',
            $listingSearchRequest,
            array(
                'method' => 'GET',
                'action' => $this->generateUrl('cocorico_listing_search_result'),
            )
        );

        return $form;
    }

    /**
     * Get Markers
     *
     * @param  Request        $request
     * @param  Paginator      $results
     * @param  \ArrayIterator $resultsIterator
     * @return array
     */
    protected function getMarkers(Request $request, $results, $resultsIterator)
    {
        //We get listings id of current page to change their marker aspect on the map
        $resultsInPage = array();
        foreach ($resultsIterator as $i => $result) {
            $resultsInPage[] = $result[0]['id'];
        }

        //We need to display all listings (without pagination) of the current search on the map
        $results->getQuery()->setFirstResult(null);
        $results->getQuery()->setMaxResults(null);
        $nbResults = $results->count();

        $imagePath = ListingImage::IMAGE_FOLDER;
        $currentCurrency = $this->get('session')->get('currency', $this->container->getParameter('cocorico.currency'));
        $locale = $request->getLocale();
        $liipCacheManager = $this->get('liip_imagine.cache.manager');
        $currencyExtension = $this->get('lexik_currency.currency_extension');
        $markers = array();

        foreach ($results->getIterator() as $i => $result) {
            $listing = $result[0];

            $imageName = count($listing['images']) ? $listing['images'][0]['name'] : ListingImage::IMAGE_DEFAULT;

            $image = $liipCacheManager->getBrowserPath($imagePath . $imageName, 'listing_medium', array());

            $price = $currencyExtension->convertAndFormat($listing['price'] / 100, $currentCurrency, false);

            $categories = count($listing['listingListingCategories']) ?
                $listing['listingListingCategories'][0]['category']['translations'][$locale]['name'] : '';

            $isInCurrentPage = in_array($listing['id'], $resultsInPage);

            $rating1 = $rating2 = $rating3 = $rating4 = $rating5 = 'hidden';
            if ($listing['averageRating']) {
                $rating1 = ($listing['averageRating'] >= 1) ? '' : 'inactive';
                $rating2 = ($listing['averageRating'] >= 2) ? '' : 'inactive';
                $rating3 = ($listing['averageRating'] >= 3) ? '' : 'inactive';
                $rating4 = ($listing['averageRating'] >= 4) ? '' : 'inactive';
                $rating5 = ($listing['averageRating'] >= 5) ? '' : 'inactive';
            }

            $markers[] = array(
                'id' => $listing['id'],
                'lat' => $listing['location']['coordinate']['lat'],
                'lng' => $listing['location']['coordinate']['lng'],
                'title' => $listing['translations'][$locale]['title'],
                'category' => $categories,
                'image' => $image,
                'rating1' => $rating1,
                'rating2' => $rating2,
                'rating3' => $rating3,
                'rating4' => $rating4,
                'rating5' => $rating5,
                'price' => $price,
                'certified' => $listing['certified'] ? 'certified' : 'hidden',
                'url' => $url = $this->generateUrl(
                    'cocorico_listing_show',
                    array('slug' => $listing['translations'][$locale]['slug'])
                ),
                'zindex' => $isInCurrentPage ? 2 * $nbResults - $i : $i,
                'opacity' => $isInCurrentPage ? 1 : 0.4,

            );
        }

        return $markers;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchHomeFormAction()
    {
        $listingSearchRequest = $this->getListingSearchRequest();
        $form = $this->createSearchHomeForm($listingSearchRequest);

        return $this->render(
            '@CocoricoCore/Frontend/Home/form_search.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param  ListingSearchRequest $listingSearchRequest
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createSearchHomeForm(ListingSearchRequest $listingSearchRequest)
    {
        $form = $this->get('form.factory')->createNamed(
            '',
            'listing_search_home',
            $listingSearchRequest,
            array(
                'method' => 'GET',
                'action' => $this->generateUrl('cocorico_listing_search_result'),
            )
        );

        return $form;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchFormAction()
    {
        $listingSearchRequest = $this->getListingSearchRequest();
        $form = $this->createSearchForm($listingSearchRequest);

        return $this->render(
            '@CocoricoCore/Frontend/Common/form_search.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param  ListingSearchRequest $listingSearchRequest
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    protected function createSearchForm(ListingSearchRequest $listingSearchRequest)
    {
        $form = $this->get('form.factory')->createNamed(
            '',
            'listing_search',
            $listingSearchRequest,
            array(
                'method' => 'GET',
                'action' => $this->generateUrl('cocorico_listing_search_result'),
            )
        );

        return $form;
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchResultFormAction()
    {
        $listingSearchRequest = $this->getListingSearchRequest();
        $form = $this->createSearchResultForm($listingSearchRequest);

        return $this->render(
            '@CocoricoCore/Frontend/ListingResult/form_search.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * similarListingAction will list out the listings which are almost similar to what has been
     * searched.
     *
     * @Route("/listing/similar_result/{id}", name="cocorico_listing_similar")
     * @Method("GET")
     *
     * @param  Request $request
     * @param int      $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function similarListingAction(Request $request, $id = null)
    {
        $results = new ArrayCollection();
        $listingSearchRequest = $this->getListingSearchRequest();
        $ids = ($listingSearchRequest) ? $listingSearchRequest->getSimilarListings() : array();
        if ($listingSearchRequest && count($ids) > 0) {
            $results = $this->get("cocorico.listing_search.manager")->getListingsByIds(
                $ids,
                null,
                $request->getLocale(),
                array($id)
            );
        }
        return $this->render(
            '@CocoricoCore/Frontend/Listing/similar_listing.html.twig',
            array(
                'results' => $results
            )
        );
    }

    /**
     * howtowearListingAction will list out the how to wear listings what has been
     * searched.
     *
     * @Route("/listing/howtowear_result/{id}", name="cocorico_listing_howtowear")
     * @Method("GET")
     *
     * @param  Request $request
     * @param int      $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function howtowearListingAction(Request $request, $id = null)
    {
        $results = new ArrayCollection();
        
        $results = $this->get("cocorico.listing_search.manager")->gethowtowearListingsByIds(
            $id,
            $request->getLocale()
        );
        return $this->render(
            '@CocoricoCore/Frontend/Listing/howtowear_listing.html.twig',
            array(
                'results' => $results
            )
        );
    }

    /**
     * @return ListingSearchRequest
     */
    private function getListingSearchRequest()
    {
        $session = $this->get('session');
        /** @var ListingSearchRequest $listingSearchRequest */
        $listingSearchRequest = $session->has('listing_search_request') ?
            $session->get('listing_search_request') :
            $this->get('cocorico.listing_search_request');

        return $listingSearchRequest;
    }

}
