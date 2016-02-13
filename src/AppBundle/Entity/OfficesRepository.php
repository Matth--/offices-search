<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfficesRepository extends EntityRepository
{
    public function findByCity($name, $is_open_in_weekends, $has_support_desk)
    {
        $parameters = array(
            'city' => $name,
        );

        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('o')
            ->from('AppBundle:Office', 'o')
            ->where('LOWER(o.city) = LOWER(:city)');
        if($is_open_in_weekends) {
            $queryBuilder->andWhere('o.is_open_in_weekends = :is_open_in_weekends');
            $parameters['is_open_in_weekends'] = 'Y';
        }
        if($has_support_desk) {
            $queryBuilder->andWhere('o.has_support_desk = :has_support_desk');
            $parameters['has_support_desk'] = 'Y';
        }
        return $queryBuilder->setParameters($parameters)
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }

    public function findByLatAndLong($lat, $long, $is_open_in_weekends, $has_support_desk, $distance = 25)
    {
        $parameters = array(
            'lat' => $lat,
            'long' => $long,
            'distance' => $distance,
        );

        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder->select('o.id, o.street, o.city, o.latitude, o.longitude, o.is_open_in_weekends, o.has_support_desk,
            ( 6371 * ACOS( cos( radians(:lat) ) * cos( radians( o.latitude ) )
              * cos( radians( o.longitude ) - radians(:long) ) + sin( radians(:lat) ) * sin(radians(o.latitude)) ) ) AS distance
            ')
            ->from('AppBundle:Office', 'o');

        if($is_open_in_weekends) {
            $queryBuilder->andWhere('o.is_open_in_weekends = :is_open_in_weekends');
            $parameters['is_open_in_weekends'] = 'Y';
        }
        if($has_support_desk) {
            $queryBuilder->andWhere('o.has_support_desk = :has_support_desk');
            $parameters['has_support_desk'] = 'Y';
        }

        $queryBuilder->having('distance < :distance')
            ->orderBy('distance')
            ->setParameters($parameters)
            ->setMaxResults(20);
        return $queryBuilder->getQuery()->getResult();
    }
}
