<?php

namespace Tobias\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Tobias\BlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\Response;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articleQuery = $em->createQuery(
            'SELECT a.id, a.slug, a.createdSlug, a.hash, a.content FROM TobiasBlogBundle:Article a ORDER BY a.created DESC'
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articleQuery, $this->get('request')->query->get('page', 1), 5);

        $response = $this->render('TobiasBlogBundle:Article:index.html.twig', array('pagination' => $pagination));
        $response->setSharedMaxAge(15);

        return $response;
    }

    /**
     * Finds and displays a Article entity.
     */
    public function showAction($createdSlug, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->createQuery('SELECT a.id, a.hash, a.title FROM TobiasBlogBundle:Article a WHERE a.slug = :slug AND a.createdSlug = :createdSlug')
            ->setParameter('slug', $slug)
            ->setParameter('createdSlug', $createdSlug)
            ->getSingleResult();

        if (!$article)
            throw $this->createNotFoundException('Unable to find Article.');

        $response = $this->render('TobiasBlogBundle:Article:show.html.twig', array('article' => $article));
        $response->setSharedMaxAge(15);

        return $response;
    }

    /**
     * Finds and renders the stub of an Article entity.
     */
    public function renderStubAction($id, $hash)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->find($id);

        if (!$article)
            throw $this->createNotFoundException('Unable to find Article.');

        $response = $this->render('TobiasBlogBundle:Article:articleStub.html.twig', array('article' => $article));
        $response->setSharedMaxAge(7 * 24 * 3600);
        
        return $response;
    }

    /**
     * Finds and renders the remaining body of an Article entity.
     */
    public function renderBodyAction($id, $hash)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->find($id);

        if (!$article)
            throw $this->createNotFoundException('Unable to find Article.');

        $response = $this->render('TobiasBlogBundle:Article:articleBody.html.twig', array('article' => $article));
        $response->setSharedMaxAge(7 * 24 * 3600);
        
        return $response;
    }

    /**
     * Renders comments for an Article entity.
     *
     */
    public function renderCommentsAction($id, $hash)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->find($id);

        if (!$article)
            throw $this->createNotFoundException('Unable to find Article.');

        $response = $this->render('TobiasBlogBundle:Article:articleComments.html.twig', array('article' => $article));
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
        $logger = $this->get('logger');
        $logger->debug('Retrieving articles');


        $em = $this->getDoctrine()->getManager();

        $articles = $em->createQuery(
            'SELECT a FROM TobiasBlogBundle:Article a ORDER BY a.created DESC'
        )->setMaxResults(20)->getResult();


        $logger->debug('Retrieving feed manager');
        $feed = $this->get('eko_feed.feed.manager')->get('article');

        $logger->debug('Adding articles to feed manager');
        $feed->addFromArray($articles);

        $logger->debug('Rendering feed');
        

        $response = new Response($feed->render($_format));
        $response->setSharedMaxAge(600);
        
        return $response;
    }
}
