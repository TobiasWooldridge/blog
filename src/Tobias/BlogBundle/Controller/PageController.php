<?php

namespace Tobias\BlogBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tobias\BlogBundle\Entity\Page;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Page controller.
 */
class PageController
{
	/**
	 * @DI\Inject("doctrine.orm.entity_manager")
	 * @var \Doctrine\ORM\EntityManager
	 */
    protected $em;

	/**
	 * @DI\Inject("templating")
	 */
    protected $templating;

    /**
     * Finds and displays a Page entity.
     */
    public function showAction($slug)
    {
        $page = $this->em->getRepository('TobiasBlogBundle:Page')->findOneBySlug($slug);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $response = $this->templating->renderResponse('TobiasBlogBundle:Page:show.html.twig', array('page' => $page));
        $response->setSharedMaxAge(300);

        return $response;
    }

}
