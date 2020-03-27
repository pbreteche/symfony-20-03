<?php

namespace App\SearchQuery;

use App\Repository\BoardGameRepository;

class BoardGameQuery
{
    private $repository;

    public function __construct(BoardGameRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \App\Entity\BoardGame[]
     */
    public function createCriteria(string $query)
    {
        $criteriaStrings = explode('+', $query);

        $criteriaAsArray = [];

        foreach ($criteriaStrings as $criteria) {
            [$fieldName, $value] = explode('=', $criteria);
            $criteriaAsArray[$fieldName] = $value;
        }

        $builder = $this->repository->createQueryBuilder('bg');

        foreach($criteriaAsArray as $field => $value) {
            // création de la requête
        }

        return $builder->getQuery()->getResult();
    }
}