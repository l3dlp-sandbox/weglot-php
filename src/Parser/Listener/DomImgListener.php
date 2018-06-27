<?php

namespace Weglot\Parser\Listener;

use Weglot\Client\Api\Enum\WordType;
use Weglot\Client\Api\Exception\InvalidWordTypeException;
use Weglot\Parser\Event\ParserCrawlerAfterEvent;
use Weglot\Parser\Parser;

class DomImgListener
{
    /**
     * @param ParserCrawlerAfterEvent $event
     *
     * @throws InvalidWordTypeException
     */
    public function __invoke(ParserCrawlerAfterEvent $event)
    {
        $crawler = $event->getContext()->getCrawler();

        $nodes = $crawler->filterXPath('//img[not(ancestor-or-self::*[@' .Parser::ATTRIBUTE_NO_TRANSLATE. '])]/@*[name()=\'src\' or name()=\'alt\']');
        foreach ($nodes as $node) {
            $value = trim($node->value);

            $type = null;
            switch ($node->localName) {
                case 'alt':
                    $type = WordType::IMG_ALT;
                    break;
                case 'src':
                    $type = WordType::IMG_SRC;
                    break;
            }

            if ($value !== '' && !is_null($type)) {
                $event->getContext()->addWord($value, function ($translated) use ($node) {
                    $node->value = $translated;
                }, $type);
            }
        }
    }
}
