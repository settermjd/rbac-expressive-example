<?php

namespace Admin\Middleware;

use Admin\Entity\Article;
use Admin\Entity\User;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class RbacMiddlewareFactory
 * @package Admin\Middleware
 */
class RbacMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return RbacMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        $template = $container->get(TemplateRendererInterface::class);

        return new RbacMiddleware($template, new User(), new Article());
    }
}
