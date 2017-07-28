<?php

namespace Admin;

use Admin\Action\{
    CreatePageAction, CreatePageFactory, DeletePageAction, DeletePageFactory, EditPageAction, EditPageFactory, ListRecordsPageAction, ListRecordsPageFactory
};
use Admin\Middleware\RbacMiddleware;
use Admin\Middleware\RbacMiddlewareFactory;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

/**
 * The configuration provider for the Admin module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                CreatePageAction::class => CreatePageFactory::class,
                EditPageAction::class => EditPageFactory::class,
                DeletePageAction::class => DeletePageFactory::class,
                ListRecordsPageAction::class => ListRecordsPageFactory::class,
                RbacMiddleware::class => RbacMiddlewareFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'admin'    => [__DIR__ . '/../templates/admin'],
            ],
        ];
    }
}
