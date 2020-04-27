<?php

declare(strict_types=1);


class Request
{
    private $queryBag;

    public function __construct(array $query)
    {
        $this->queryBag = $query;
    }

    public function getQuery(): array
    {
        return $this->queryBag;
    }

    public static function create()
    {
        return new static($_GET);
    }


}