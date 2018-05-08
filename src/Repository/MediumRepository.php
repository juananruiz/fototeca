<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Image\Medium;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Medium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medium[]    findAll()
 * @method Medium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Medium::class);
    }

    /**
     * @param Medium $medium
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public
    function save(Medium $medium)
    {
        $this->getEntityManager()->persist($medium);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Medium $medium
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public
    function delete(Medium $medium)
    {
        $this->getEntityManager()->remove($medium);
        $this->getEntityManager()->flush();
    }
}