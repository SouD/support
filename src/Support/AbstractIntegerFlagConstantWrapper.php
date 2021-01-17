<?php

declare(strict_types=1);
namespace Soud\Support;

/**
 * Wrapper class for integer flags.
 *
 * Wraps around integer constants, with the intention of making it easier
 * to use the aforementioned constants as bitwise flags.
 *
 * @author Linus Sörensen <sorensen.linus@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class AbstractIntegerFlagConstantWrapper extends AbstractConstantWrapper
{
    /**
     * @param int[] $flags
     */
    public static function getMask(array $flags = []): int
    {
        if (!$flags) {
            $flags = static::getConstantValues();
        }

        if ($flags) {
            return array_reduce($flags, function (int $carry, $item) {
                if (is_numeric($item)) {
                    return $carry | ((int) $item);
                } else {
                    return $carry;
                }
            }, 0);
        } else {
            return -1;
        }
    }
}
