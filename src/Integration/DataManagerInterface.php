<?php


namespace App\Integration;


interface DataManagerInterface
{
    /**
     * @param string $endpoint
     * @param string $value
     * @return array
     */

    public function getData(string $endpoint, string $value): array;
}