<?php

declare(strict_types=1);
namespace Soud\Support;

use ReflectionClass;

/**
 * Wrapper class for integer flags.
 *
 * Wraps around integer constants, with the intention of making it easier
 * to use the aforementioned constants as bitwise flags.
 *
 * @author Linus Sörensen <sorensen.linus@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractConstantWrapper
{
    /**
     * @throws ReflectionException
     */
    public static function getConstants(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    public static function getConstantValues(): array
    {
        return array_values(static::getConstants());
    }

    public static function getConstantKeys(): array
    {
        return array_keys(static::getConstants());
    }
}
