<?php

namespace Vipa\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * RoleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoleRepository extends EntityRepository
{
    /**
     * @param  array $ids
     * @return array
     */
    public function findInIds($ids = [])
    {
        $qb = $this->createQueryBuilder('r');
        $qb->where(
            $qb->expr()->in('r.id', ':ids')
        )
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getAllNames()
    {
        $result = $this->createQueryBuilder('role')
            ->select('role.name')->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        return $result;
    }
}
