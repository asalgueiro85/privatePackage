<?php

namespace AppBundle\Entity\Repository;

/**
 * NotifyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotifyRepository extends \Doctrine\ORM\EntityRepository
{
    public function myNotify($id){
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select("n")
            ->from("AppBundle:Notify","n")
            ->innerJoin("n.user", "u")
            ->where("u.id =:id")
            ->setParameter("id",$id);
//            ->orderBy()
//            ->expr()->asc('n.state')
            $query->orderBy($query->expr()->asc('n.state'));
//            ->getQuery()
//            ->getResult();

//        $query->orderBy($query->expr()->asc('activity.name'));
//        $query->setParameter('category', $category);
//
        return $query->getQuery()->getResult();
        return $query;
    }
}
