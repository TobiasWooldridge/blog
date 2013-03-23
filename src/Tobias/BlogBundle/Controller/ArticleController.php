<?php

namespace Tobias\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tobias\BlogBundle\Entity\Article;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     * @Route("/", name="article")
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
        $response->setSharedMaxAge(60);

        return $response;
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/blog/{createdSlug}/{slug}", name="article_show")
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
        $response->setSharedMaxAge(60);

        return $response;
    }

    /**
     * Finds and renders the stub of an Article entity.
     *
     * @Route("/esi/blog/{id}/stub/{hash}", name="article_render_stub")
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
     *
     * @Route("/esi/blog/{id}/body/{hash}", name="article_render_body")
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
     * @Route("/esi/blog/{id}/comments/{hash}", name="article_render_comments")
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
}
