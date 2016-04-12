<?php namespace IEPC\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IEPC\ContentBundle\Entity\WebPage;
use IEPC\WebsiteBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @package IEPC\WebsiteBundle\DataFixtures\ORM
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
        $frontPage->setContent('<h1>Frontpage</h1>')
                  ->setName('FrontPage');

        $transparenciaFrontPage = new Page();
        $transparenciaFrontPage->setContent('<h1>Transparencia placeholder</h1>')
            ->setName('Transparencia frontpage');

        $participacionFrontPage = new Page();
        $participacionFrontPage->setContent('<h1>Participación Ciudadana</h1>')
            ->setName('Participación frontpage');

        $participacionFrontPlebiscito = new Page();
        $participacionFrontPlebiscito->setContent('<article><h1>Plebiscito</h1></article>')
            ->setName('Participación: Plebiscito');

        $participacionReferendum = new Page();
        $participacionReferendum->setContent('<article><h1>Referéndum</h1></article>')
            ->setName('Participación: Referéndum');

        $em->persist($frontPage);
        $em->persist($transparenciaFrontPage);

        $em->persist($participacionFrontPage);
        $em->persist($participacionFrontPlebiscito);
        $em->persist($participacionReferendum);

        $em->flush();

        $this->addReference('page-front',         $frontPage);
        $this->addReference('page-transparencia', $transparenciaFrontPage);

        $this->addReference('page-participacion',            $participacionFrontPage);
        $this->addReference('page-participacion-plebiscito', $participacionFrontPlebiscito);
        $this->addReference('page-participacion-referendum', $participacionReferendum);
    }
}