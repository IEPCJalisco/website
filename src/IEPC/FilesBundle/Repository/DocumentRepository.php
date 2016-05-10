<?php namespace IEPC\FilesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use IEPC\FilesBundle\Entity\Document;

/**
 * @package IEPC\FilesBundle\Repository
 */
class DocumentRepository extends EntityRepository
{
    /**
     * @param string $path
     * @return Document
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByPath($path)
    {
        if (substr($path, 0, 1) != '/') {
            $path = "/{$path}";
        }

        $qb = $this->createQueryBuilder('d');
        $qb->where($qb->expr()->eq('d.fullPath', ':path'))
            ->setParameter('path', $path);

        return $qb->getQuery()->getSingleResult();
    }
}