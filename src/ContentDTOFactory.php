<?php

namespace Domattr\Exml;

class ContentDTOFactory
{
    private const PATTERN = "/<(?'tag'[a-zA-Z\:]+)(?:\w*>|\s+(?'attributes'.*?)\w*\/?>)(?:(?'contents'.*?)<\/\k<tag>>)?/s";
    private const HEADER_PATTERN = "/^<\?xml version=\"(?'version'\d\.\d)\"(?:\s+encoding=\"(?'encoding'.*)\")?\?>/";

    public static function create(string $xml): array|ContentDTO|string
    {
        preg_match_all(self::PATTERN, html_entity_decode($xml), $matches);

        if (count($matches[0]) == 0) {
            return $xml;
        }

        if (count($matches[0]) == 1) {
            preg_match(self::HEADER_PATTERN,$xml,$header_matches);
            return new ContentDTO($matches['tag'][0], $matches['attributes'][0], $matches['contents'][0], $header_matches);
        }

        $dtos = [];
        for ($i = 0; $i < count($matches[0]); $i++) {
            $dtos[] = new ContentDTO($matches['tag'][$i], $matches['attributes'][$i], $matches['contents'][$i]);
        }
        return $dtos;
    }
}
