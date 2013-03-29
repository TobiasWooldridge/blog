<?php

namespace Tobias\BlogBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Tobias\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Article controller.
 *
 */
class ArticleController
{
	/**
	 * @DI\Inject("doctrine.orm.entity_manager")
	 * @var \Doctrine\ORM\EntityManager
	 */
    protected $em;

	/**
	 * @DI\Inject("knp_paginator")
	 * @var Knp\Component\Pager\Paginator
	 */
    protected $paginator;

	/**
	 * @DI\Inject("request")
	 * @var Request
	 */
    protected $request;

	/**
	 * @DI\Inject("templating")
	 */
    protected $templating;

	/**
	 * @DI\Inject("eko_feed.feed.manager")
	 */
    protected $fm;

    /**
     * Lists all Article entities.
     */
    public function indexAction()
    {
        $articleQuery = $this->em->createQuery( 
            'SELECT a.id, a.slug, a.createdSlug, a.hash, a.content FROM TobiasBlogBundle:Article a ORDER BY a.created DESC'
        );

        $pagination = $this->paginator->paginate($articleQuery, $this->request->query->get('page', 1), 5);

        $response = $this->templating->renderResponse('TobiasBlogBundle:Article:index.html.twig', array('pagination' => $pagination));
        $response->setSharedMaxAge(15);

        return $response;
    }

    /**
     * Finds and displays a Article entity.
     */
    public function showAction($createdSlug, $slug)
    {
        $article = $this->em->createQuery('SELECT a.id, a.hash, a.title FROM TobiasBlogBundle:Article a WHERE a.slug = :slug AND a.createdSlug = :createdSlug')
            ->setParameter('slug', $slug)
            ->setParameter('createdSlug', $createdSlug)
            ->getSingleResult();

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        $response = $this->templating->renderResponse('TobiasBlogBundle:Article:show.html.twig', array('article' => $article));
        $response->setSharedMaxAge(15);

        return $response;
    }

    /**
     * Finds and renders the stub of an Article entity.
     */
    public function renderStubAction($id, $hash)
    {
        $article = $this->em->getRepository('TobiasBlogBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        $response = $this->templating->renderResponse('TobiasBlogBundle:Article:articleStub.html.twig', array('article' => $article));
        $response->setSharedMaxAge(7 * 24 * 3600);
        
        return $response;
    }

    /**
     * Finds and renders the remaining body of an Article entity.
     */
    public function renderBodyAction($id, $hash)
    {
        $article = $this->em->getRepository('TobiasBlogBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        $response = $this->templating->renderResponse('TobiasBlogBundle:Article:articleBody.html.twig', array('article' => $article));
        $response->setSharedMaxAge(7 * 24 * 3600);
        
        return $response;
    }

    /**
     * Renders comments for an Article entity.
     *
     */
    public function renderCommentsAction($id, $hash)
    {
        $article = $this->em->getRepository('TobiasBlogBundle:Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        $response = $this->templating->renderResponse('TobiasBlogBundle:Article:articleComments.html.twig', array('article' => $article));
        $response->setSharedMaxAge(3600);
        
        return $response;
    }

    /**
     * Article feed
     *
     * @return Response
     */
    public function feedAction($_format)
    {
        $articles = $this->em->createQuery(
            'SELECT a FROM TobiasBlogBundle:Article a ORDER BY a.created DESC'
        )->setMaxResults(20)->getResult();

        $feed = $this->fm->get('article');

        $feed->addFromArray($articles);

        $response = new Response($feed->render($_format));
        $response->setSharedMaxAge(600);
        
        return $response;
    }
}
