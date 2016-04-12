<?php namespace IEPC\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;
use IEPC\ContentBundle\Entity\WebPage;

/**
 * @package IEPC\ContentBundle\Repository
 */
class WebPageRepository extends EntityRepository
{
    /**
     * @param string $path
     * @return WebPage
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByPath($path)
    {
        if (substr($path, 0, 1) != '/') {
            $path = "/{$path}";
        }

        $qb = $this->createQueryBuilder('w');
        $qb->where($qb->expr()->eq('w.fullPath', ':path'))
            ->setParameter('path', $path);

        return $qb->getQuery()->getSingleResult();
    }
}
