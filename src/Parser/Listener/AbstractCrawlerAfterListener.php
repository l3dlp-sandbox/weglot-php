<?php

namespace Weglot\Parser\Listener;

use Weglot\Client\Api\Exception\InvalidWordTypeException;
use Weglot\Parser\Event\ParserCrawlerAfterEvent;
use Weglot\Parser\Exception\ParserCrawlerAfterListenerException;
use Weglot\Parser\Parser;
use Weglot\Util\Text;

/**
 * Class AbstractCrawlerAfterListener.
 * @package Weglot\Parser\Listener
 */
abstract class AbstractCrawlerAfterListener
{
    /**
     * @param ParserCrawlerAfterEvent $event
     *
     * @throws ParserCrawlerAfterListenerException
     * @throws InvalidWordTypeException
     */
    public function __invoke(ParserCrawlerAfterEvent $event)
    {
        $crawler = $event->getContext()->getCrawler();
        $xpath = $this->xpath();

        if ($xpath === '' || strpos($xpath, Parser::ATTRIBUTE_NO_TRANSLATE) === false) {
            throw new ParserCrawlerAfterListenerException('XPath query is empty or doesn\'t exclude non-translable blocks.');
        }

        $nodes = $crawler->filterXPath($xpath);
        foreach ($nodes as $node) {
            $value = $this->value($node);
            $value = $this->fix($node, $value);

            if ($this->validation($node, $value)) {
                $event->getContext()->addWord($value, $this->replaceCallback($node));
            }
        }
    }

    /**
     * Returns current listener XPath query
     *
     * @return string
     */
    abstract protected function xpath();

    /**
     * Return current node used value
     *
     * @param \DOMNode $node
     * @return string
     */
    protected function value(\DOMNode $node)
    {
        if ($node instanceof \DOMAttr) {
            return $node->value;
        }
        return $node->textContent;
    }

    /**
     * Fix given value based on node type
     *
     * @param \DOMNode $node
     * @param string $value
     * @return string
     */
    protected function fix(\DOMNode $node, $value)
    {
        $fixed = Text::fullTrim($value);
        if ($node instanceof \DOMText) {
            $fixed = str_replace("\n", '', $fixed);
            $fixed = preg_replace('/\s+/', ' ', $fixed);
        }

        return $fixed;
    }

    /**
     * Some default checks for our value depending on node type
     *
     * @param \DOMNode $node
     * @param string $value
     * @return bool
     */
    protected function validation(\DOMNode $node, $value)
    {
        $boolean = $value !== '';

        if ($node instanceof \DOMText) {
            $boolean = $boolean && strpos($value, Parser::ATTRIBUTE_NO_TRANSLATE) === false;
        }

        return $boolean;
    }

    /**
     * Callback used to replace text with translated version
     *
     * @param \DOMNode $node
     * @return callable
     */
    protected function replaceCallback(\DOMNode $node)
    {
        return function ($translated) use ($node) {
            if ($node instanceof \DOMText) {
                $node->textContent = $translated;
            } elseif ($node instanceof \DOMAttr) {
                $node->value = $translated;
            } else {
                throw new ParserCrawlerAfterListenerException('No callback behavior set for this node type.');
            }
        };
    }
}
