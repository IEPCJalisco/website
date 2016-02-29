<?php namespace IEPC\WebsiteBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use IEPC\ContentBundle\Entity\Section;

/**
 *
 * @package IEPCWebsiteBundle
 * @version 0.1
 */
class Sections extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {
        $front = new Section('Front');
        $front->setPath('');

        $transparencia = new Section('Transparencia');
        $transparencia->setPath('transparencia')
                      ->setParent($front);

        $participacion = new Section('Participación Ciudadana');
        $participacion->setPath('participacion-ciudadana')
                      ->setLayout('participacion-ciudadana')
                      ->setParent($front);

        $em->persist($front);
        $em->persist($transparencia);
        $em->persist($participacion);
        $em->flush();

        $this->addReference('section-front',         $front);
        $this->addReference('section-transparencia', $transparencia);
        $this->addReference('section-participacion', $participacion);
    }
}