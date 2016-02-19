<?php namespace IEPC\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEPC\ContentBundle\Entity\Section;
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
        $mainSection          = $this->getReference('section-front');
        $transparenciaSection = $this->getReference('section-transparencia');
        $participacionSection = $this->getReference('section-participacion');

        $transparencia01 = new Page();
        $transparencia01->setContent('<main><h1>Transparencia</h1></main>');
        $transparenciaPage = new WebPage();
        $transparenciaPage->setContent($transparencia01);
        $transparenciaPage->setSection($transparenciaSection);
        $transparenciaPage->setPath('');

        $participacion01 = new Page();
        $participacion01->setContent('<main><h1>Transparencia</h1></main>');
        $participacionPage = new WebPage();
        $participacionPage->setContent($participacion01);
        $participacionPage->setSection($participacionSection);
        $participacionPage->setPath('');

        $em->persist($transparencia01);
        $em->persist($transparenciaPage);
        $em->persist($participacion01);
        $em->persist($participacionPage);
        $em->flush();
    }
}