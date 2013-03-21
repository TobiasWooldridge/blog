<?php
namespace Tobias\BlogBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;
 

class BlogExtension extends Twig_Extension
{
    protected $container;
 
    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            'date_tag' => new \Twig_Filter_Method($this, 'dateTagFilter', array('is_safe' => array('html'))),
            'markdown' => new \Twig_Filter_Method($this, 'markdownFilter', array('is_safe'=>array('html')))
        );
    }

    public function dateTagFilter(\DateTime $date, $format = 'c')
    {
        return '<time datetime="' . $date->format('c') . '">' . $date->format($format) . '</time>';
    }

    public function markdownFilter($markdown_source)
    {
        return $this->container->get('varspool_markdown')->render($markdown_source);
    }

    public function getName()
    {
        return 'blog_extension';
    }
}