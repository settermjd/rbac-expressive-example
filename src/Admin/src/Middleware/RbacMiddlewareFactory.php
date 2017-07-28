<?php

namespace Admin\Middleware;

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

        $user = new class {
            public function getRole() {
                return 'content.editor';
            }
            public function getId()
            {
                return 25;
            }
        };

        $article = new class {
            public function getUserId()
            {
                return 25;
            }
        };

        return new RbacMiddleware($template, $user, $article);
    }
}
