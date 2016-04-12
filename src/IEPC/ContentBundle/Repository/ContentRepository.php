<?php namespace IEPC\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;
use IEPC\ContentBundle\Model\ContentInterface;

class ContentRepository extends EntityRepository
{
    /**
     * @param string $name
     * @return ContentInterface
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByName($name)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where($qb->expr()->eq('c.name', ':name'))
            ->setParameter('name', $name);

        return $qb->getQuery()->getSingleResult();
    }
}
