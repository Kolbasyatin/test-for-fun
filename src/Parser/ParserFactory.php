<?php

declare(strict_types=1);


namespace App\Parser;


/**
 * Class ParserFactory
 * @package App\Parser
 */
class ParserFactory
{
    /**
     * @param string|null $type
     * @return ParserInterface
     * @throws ParserException
     */
    public static function getParser(?string $type = 'json'): ParserInterface
    {
        if ('json' === $type) {
            return new JsonParser();
        }
        if ('xml' === $type) {
            return new XmlParser();
        }

        throw new ParserException('There is no appropriate parser with type ' . $type);
    }
}