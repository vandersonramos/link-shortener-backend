<?php

namespace App\Services;

use App\Repository\LinksRepository;
use App\Entity\Links;

class LinksService
{

    private $repository;

    public function __construct(LinksRepository $linksRepository)
    {
        $this->repository = $linksRepository;
    }

    /**
     * @return string
     */
    public function generateShorterUrl()
    {
        return $this->repository->generateShorterUrl();
    }

    /**
     * @param Links $link
     * @return Links|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Links $link)
    {
        $link = $this->repository->save($link);
        return $link;
    }

    /**
     * @param $link
     * @return Links|null
     */
    public function findOneByShorterUrl($link)
    {
        return $this->repository->findOneByShorterUrl($link);
    }

    /**
     * @param Links $link
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateViews(Links $link)
    {
        $link->incrementViews();
        $this->repository->updateViews($link);
    }

}
