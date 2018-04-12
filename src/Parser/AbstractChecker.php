<?php
/**
 * Created by PhpStorm.
 * User: bleduc
 * Date: 12/04/2018
 * Time: 17:10
 */

namespace Weglot\Parser;

use SimpleHtmlDom\simple_html_dom;

abstract class AbstractChecker
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var simple_html_dom
     */
    protected $dom;

    /**
     * DomChecker constructor.
     * @param Parser $parser
     * @param simple_html_dom $dom
     */
    public function __construct(Parser $parser, simple_html_dom $dom)
    {
        $this
            ->setParser($parser)
            ->setDom($dom);
    }

    /**
     * @param Parser $parser
     * @return $this
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * @return Parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @param simple_html_dom $dom
     * @return $this
     */
    public function setDom(simple_html_dom $dom)
    {
        $this->dom = $dom;

        return $this;
    }

    /**
     * @return simple_html_dom
     */
    public function getDom()
    {
        return $this->dom;
    }
}
