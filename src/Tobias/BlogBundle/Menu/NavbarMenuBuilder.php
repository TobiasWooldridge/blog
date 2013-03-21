<?php
namespace Tobias\BlogBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;

class NavbarMenuBuilder extends AbstractNavbarMenuBuilder
{
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $menu->addChild('Github', array('uri' => 'https://github.com/TobiasWooldridge/'));
        $menu->addChild('Blog', array('route' => 'article'));
        $menu->addChild('About Me', array('route' => 'page_show', 'routeParameters' => array('slug' => 'about-me')));

        return $menu;
    }
}