<?php

namespace Weglot\Parser\Listener;

use Weglot\Parser\Event\ParserTranslatedEvent;

final class DomReplaceListener
{
    /**
     * @param ParserTranslatedEvent $event
     */
    public function __invoke(ParserTranslatedEvent $event)
    {
        $replaceMap = $event->getContext()->getTranslateMap();
        $outputWords = $event->getContext()->getTranslateEntry()->getOutputWords();

        foreach ($replaceMap as $index => $callable) {
            $wordType = $outputWords[$index];
            call_user_func($callable, $wordType->getWord());
        }
    }
}
