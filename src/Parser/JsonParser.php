<?php

declare(strict_types=1);


namespace App\Parser;


class JsonParser implements ParserInterface
{
    public function parse(array $data): string
    {
        return json_encode($data);
    }

}