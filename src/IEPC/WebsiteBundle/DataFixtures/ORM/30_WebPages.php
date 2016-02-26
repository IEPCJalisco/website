<?php namespace IEPC\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEPC\ContentBundle\Entity\WebPage;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @package IEPCWebsiteBundle
 * @version 0.1
 */
class WebPages extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 30;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {
//        $page01 = new WebPage();
//        $page02 = new WebPage();
//        $page03 = new WebPage();
//
//        $page01->setSection($this->getReference('section-participacion'));
//        $page02->setSection($this->getReference('section-participacion'));
//        $page03->setSection($this->getReference('section-transparencia'));
//
//        $page01->setContent();
//        $page02->setContent();
//        $page03->setContent();
//
//        $em->flush();
    }
}