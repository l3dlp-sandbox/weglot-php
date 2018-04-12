<?php

namespace Weglot\Parser\Check\Dom;

use Weglot\Client\Api\Enum\WordType;

/**
 * Class A_title
 * @package Weglot\Parser\Check
 */
class LinkTitle extends AbstractDomChecker
{
    /**
     * {@inheritdoc}
     */
    const DOM = 'a';

    /**
     * {@inheritdoc}
     */
    const PROPERTY = 'title';

    /**
     * {@inheritdoc}
     */
    const WORD_TYPE = WordType::TEXT;
}