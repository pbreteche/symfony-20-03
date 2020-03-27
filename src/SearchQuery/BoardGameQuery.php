<?php


namespace App\SearchQuery;


class BoardGameQuery
{

    public function createCriteria(string $query): array
    {
        $criteriaStrings = explode('+', $query);

        $criteriaAsArray = [];

        foreach ($criteriaStrings as $criteria) {
            list($fieldName, $value) = explode('=', $criteria);
            $criteriaAsArray[$fieldName] = $value;
        }

        return $criteriaAsArray;
    }
}