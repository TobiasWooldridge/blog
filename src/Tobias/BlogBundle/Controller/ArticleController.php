<?php

namespace Tobias\BlogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
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
     * @Template()
     * @Cache(expires="tomorrow", smaxage="1200")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articleQuery = $em->createQuery(
            'SELECT a.slug, a.createdSlug, a.content FROM TobiasBlogBundle:Article a ORDER BY a.created DESC'
        );

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($articleQuery, $this->get('request')->query->get('page', 1), 5);

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/blog/{created_slug}/{slug}", name="article_show")
     * @Template()
     * @Cache(expires="tomorrow", smaxage="1200")
     */
    public function showAction($created_slug, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->findOneBySlug($slug);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        return array(
            'article' => $article,
        );
    }

    /**
     * Finds and renders the stub of an Article entity.
     *
     * @Route("/esi/blog/{created_slug}/{slug}/stub", name="article_render_stub")
     * @Template()
     * @Cache(expires="tomorrow", smaxage="1200")
     */
    public function renderStubAction($created_slug, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->findOneBy(array('createdSlug' => $created_slug, 'slug' => $slug));

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        return array(
            'article' => $article,
        );
    }

    /**
     * Finds and renders the remaining body of an Article entity.
     *
     * @Route("/esi/blog/{created_slug}/{slug}/body", name="article_render_body")
     * @Template()
     * @Cache(expires="tomorrow", smaxage="1200")
     */
    public function renderBodyAction($created_slug, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->findOneBy(array('createdSlug' => $created_slug, 'slug' => $slug));

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        return array(
            'article' => $article,
        );
    }

    /**
     * Finds and renders the remaining comments of an Article entity.
     *
     * @Route("/esi/blog/{created_slug}/{slug}/comments", name="article_render_comments")
     * @Template()
     * @Cache(expires="tomorrow", smaxage="1200")
     */
    public function renderCommentsAction($created_slug, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('TobiasBlogBundle:Article')->findOneBy(array('createdSlug' => $created_slug, 'slug' => $slug));

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        return array(
            'article' => $article,
        );
    }
}
