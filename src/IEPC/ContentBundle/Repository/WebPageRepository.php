<?php namespace IEPC\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WebPageRepository extends EntityRepository
{
    public function findByPath($path)
    {
        $qb = $this->createQueryBuilder('w');
        $qb->where($qb->expr()->eq('w.fullPath', ':path'))
            ->setParameter('path', $path);

        return $qb->getQuery()->getSingleResult();
    }
}
