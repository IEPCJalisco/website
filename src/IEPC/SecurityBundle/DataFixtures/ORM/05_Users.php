<?php namespace IEPC\SecurityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use IEPC\SecurityBundle\Entity\User;

class Users extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 05;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $em)
    {
        $izam = new User();
        $izam->setUsername('izambl')
            ->setEmail('izma@mabkil.com')
            ->setPlainPassword('toor12345')
            ->setRoles(['ROLE_ADMIN'])
            ->setEnabled(true);
        $em->persist($izam);
        $em->flush();
    }
}