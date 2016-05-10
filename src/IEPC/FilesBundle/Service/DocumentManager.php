<?php namespace IEPC\FilesBundle\Service;

use IEPC\ContentBundle\Model\ContentInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @package IEPC\FilesBundle\Service
 */
class DocumentManager implements ContainerAwareInterface
{
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|NULL $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * DocumentManager constructor.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }
}

