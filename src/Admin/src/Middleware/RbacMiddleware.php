<?php

namespace Admin\Middleware;

use Admin\Rbac\AssertUserIdMatches;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode\RFC\RFC7231;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouteResult;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class RbacMiddleware
 * @package Admin\Middleware
 */
class RbacMiddleware implements MiddlewareInterface
{
    /**
     * @var Rbac
     */
    private $rbac;

    /**
     * @var TemplateRendererInterface
     */
    private $template;

    private $user;
    private $article;

    /**
     * RbacMiddleware constructor.
     * @param TemplateRendererInterface|null $template
     * @param $user
     * @param $article
     */
    public function __construct(TemplateRendererInterface $template = null, $user, $article)
    {
        $this->template = $template;
        $this->user = $user;
        $this->article = $article;
        $this->rbac = new Rbac();

        $roleContentCreator = new Role('content.creator');
        $roleContentCreator->addPermission('admin.create');
        $roleContentCreator->addPermission('admin.delete');
        $roleContentCreator->addPermission('admin.edit');

        $roleContentEditor  = new Role('content.editor');
        $roleContentEditor->addPermission('admin.edit');
        
        $roleContentManager = new Role('content.manager');
        $roleContentManager->addChild($roleContentCreator);
        $roleContentManager->addChild($roleContentEditor);

        $this->rbac->addRole($roleContentManager);
        $this->rbac->addRole($roleContentCreator);
        $this->rbac->addRole($roleContentEditor);
    }

    /**
     * {@inheritDoc}
     * Determine if the user can access the current resource, based on the name of the route.
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $routeName = ($request->getAttribute(RouteResult::class))->getMatchedRouteName();

        $assertion = new AssertUserIdMatches(
            $this->user->getId(),
            $this->article->getUserId()
        );

        if (in_array($routeName, ['admin.delete', 'admin.edit']) && !$this->rbac->isGranted($this->user->getRole(), $routeName, $assertion)) {
            return new HtmlResponse($this->template->render('admin::access-denied', []), RFC7231::METHOD_NOT_ALLOWED);
        }

        if ($routeName === 'admin.create' && !$this->rbac->isGranted($this->user->getRole(), $routeName)) {
            return new HtmlResponse($this->template->render('admin::access-denied', []), RFC7231::METHOD_NOT_ALLOWED);
        }

        return $delegate->process($request);
    }
}
