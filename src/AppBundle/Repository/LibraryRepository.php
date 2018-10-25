<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Room;
use AppBundle\Entity\DataLogger;
/**
 * LibraryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LibraryRepository extends \Doctrine\ORM\EntityRepository
{

  public function getLibraryHome()
  {
      return $this->createQueryBuilder('l')
      ->select('l', 'count(rooms.id) as cant')
      ->leftJoin('l.rooms', 'rooms')
      ->getQuery()
      ->getResult();
  }
}
