<?php namespace IEPC\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEPC\ContentBundle\Entity\WebPage;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @package IEPC\WebsiteBundle\DataFixtures\ORM
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
        $mainSection          = $this->getReference('section-front');
        $transparenciaSection = $this->getReference('section-transparencia');
        $participacionSection = $this->getReference('section-participacion');

        $frontPagePage = new WebPage();
        $frontPagePage->setContent($this->getReference('page-front'))
                      ->setSection($mainSection)
                      ->setLayout('frontpage')
                      ->setPath('');

        $transparenciaPage = new WebPage();
        $transparenciaPage->setContent($this->getReference('page-transparencia'))
                          ->setSection($transparenciaSection)
                          ->setPath('');

        $participacionPage = new WebPage();
        $participacionPage->setContent($this->getReference('page-participacion'))
                          ->setSection($participacionSection)
                          ->setLayout('participacion-ciudadana-frontpage')
                          ->setPath('');

        $participacionPlebiscitoPage = new WebPage();
        $participacionPlebiscitoPage->setContent($this->getReference('page-participacion-plebiscito'))
            ->setSection($participacionSection)
            ->setPath('plebiscito');

        $em->persist($frontPagePage);
        $em->persist($transparenciaPage);

        $em->persist($participacionPage);
        $em->persist($participacionPlebiscitoPage);

        $em->flush();
    }
}