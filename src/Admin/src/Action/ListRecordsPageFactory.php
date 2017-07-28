<?php

namespace Admin\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ListRecordsPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var RouterInterface|FastRouteRouter $router */
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new ListRecordsPageAction($router, $template);
    }
}
