<?php


namespace App\Integration;

interface DataProviderInterface
{
    public function get(string $record, ?array $data = null): array;
}