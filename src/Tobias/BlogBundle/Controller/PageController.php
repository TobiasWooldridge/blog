<?php

namespace Tobias\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Tobias\BlogBundle\Entity\Page;

/**
 * Page controller.
 *
 * @Route("/page")
 * @Cache(smaxage="1200")
 */
class PageController extends Controller
{
    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{slug}", name="page_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TobiasBlogBundle:Page')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
