<?php

namespace Tobias\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tobias\BlogBundle\Entity\Page;

/**
 * Page controller.
 */
class PageController extends Controller
{
    /**
     * Finds and displays a Page entity.
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('TobiasBlogBundle:Page')->findOneBySlug($slug);

        if (!$page)
            throw $this->createNotFoundException('Unable to find Page entity.');

        $response = $this->render('TobiasBlogBundle:Page:show.html.twig', array('page' => $page));
        $response->setSharedMaxAge(300);

        return $response;
    }

}
