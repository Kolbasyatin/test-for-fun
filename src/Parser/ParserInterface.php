<?php


namespace App\Parser;


interface ParserInterface
{
    public function parse(array $data): string;
}