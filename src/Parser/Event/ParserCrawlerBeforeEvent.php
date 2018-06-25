<?php

namespace Weglot\Parser\Event;

use Weglot\Parser\Parser;

class ParserCrawlerBeforeEvent extends AbstractEvent
{
    const NAME = 'parser.crawler.before';

    /**
     * @var string
     */
    protected $source;

    /**
     * ParserInitEvent constructor.
     * @param Parser $parser
     * @param string $source
     */
    public function __construct(Parser $parser, $source)
    {
        parent::__construct($parser);
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}
