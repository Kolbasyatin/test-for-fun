<?php

declare(strict_types=1);


namespace App\Parser;


class XmlParser implements ParserInterface
{
    public function parse(array $data): string
    {
        $xml = new \SimpleXMLElement('<root/>');
        array_walk_recursive($data, array($xml, 'addChild'));

        return $xml->asXML();
    }

}