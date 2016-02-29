<?php namespace IEPC\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEPC\ContentBundle\Entity\WebPage;
use IEPC\WebsiteBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @package IEPCWebsiteBundle
 * @version 0.1
 */
class Pages extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 20;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {
        $frontPage = new Page();
        $frontPage->setContent('<main><h1>Frontpage</h1></main>');

        $transparenciaFrontPage = new Page();
        $transparenciaFrontPage->setContent('<main><h1>Transparencia placeholder</h1></main>');

        $participacionFrontPage = new Page();
        $participacionFrontPage->setContent('<main><h1>Participación Ciudadana</h1></main>');

        $em->persist($frontPage);
        $em->persist($transparenciaFrontPage);
        $em->persist($participacionFrontPage);

        $em->flush();

        $this->addReference('page-front',         $frontPage);
        $this->addReference('page-transparencia', $transparenciaFrontPage);
        $this->addReference('page-participacion', $participacionFrontPage);
    }
}