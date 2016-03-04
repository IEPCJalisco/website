<?php namespace IEPC\ContentBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContentManager implements ContainerAwareInterface
{
    private $container;

    public function getContentTypes()
    {
        $contentTypes = $this->container->getParameter('content_types');

        return $contentTypes;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }
}
