<?php

namespace Weglot\Parser\Check;

use Weglot\Client\Api\Enum\WordType;
use Weglot\Parser\Util\Text as TextUtil;

/**
 * Class Placeholder
 * @package Weglot\Parser\Check
 */
class Placeholder extends AbstractChecker
{
    /**
     * {@inheritdoc}
     */
    const DOM = 'input[type="text"],input[type="password"],input[type="search"],input[type="email"],input:not([type]),textarea';

    /**
     * {@inheritdoc}
     */
    const PROPERTY = 'placeholder';

    /**
     * {@inheritdoc}
     */
    const WORD_TYPE = WordType::PLACEHOLDER;

    /**
     * {@inheritdoc}
     */
    protected function check()
    {
        return (!is_numeric(TextUtil::fullTrim($this->node->placeholder))
            && !preg_match('/^\d+%$/', TextUtil::fullTrim($this->node->placeholder)));
    }
}
