<?php

namespace App\Repository;

use App\Entity\Links;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Links|null find($id, $lockMode = null, $lockVersion = null)
 * @method Links|null findOneBy(array $criteria, array $orderBy = null)
 * @method Links[]    findAll()
 * @method Links[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinksRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Links::class);
    }

    public function findOneByShorterUrl($value): ?Links
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.url_shorter = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }


    /**
     * @return string
     */
    public function generateShorterUrl(): string
    {
        $code = substr(md5(uniqid(rand(), true)),0,6);
        $codeDb = $this->findOneByShorterUrl($code);

        if (is_null($codeDb)) {
            return $code;
        }

        $this->generateShorterUrl();
    }

    /**
     * @param $entity
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush($entity);
        return $entity;
    }

    /**
     * @param $entity
     * @return mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateViews($entity)
    {
        return $this->save($entity);
    }

}
