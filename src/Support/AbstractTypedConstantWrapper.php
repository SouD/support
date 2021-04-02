<?php

declare(strict_types=1);
namespace Soud\Support;

/**
 * Typed wrapper class for constant values.
 *
 * Heavily inspired by Matthias Pigulla's post, "Expressive, type-checked constants (aka Enums) for PHP".
 *
 * @author Linus Sörensen <sorensen.linus@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 * @see https://www.webfactory.de/blog/expressive-type-checked-constants-for-php
 */
abstract class AbstractTypedConstantWrapper extends AbstractConstantWrapper
{
    /**
     * @var array<string, mixed>
     */
    protected static $instances = [];

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    final protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param mixed $value
     */
    protected static function constant($value): static
    {
        return static::$instances[$value] ?? static::$instances[$value] = new static($value);
    }
}
