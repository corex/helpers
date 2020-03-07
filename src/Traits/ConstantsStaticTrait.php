<?php

declare(strict_types=1);

namespace CoRex\Helpers\Traits;

use CoRex\Helpers\Obj;

trait ConstantsStaticTrait
{
    /**
     * Get class constants.
     *
     * @return string[]
     */
    private static function getClassConstants(): array
    {
        return Obj::getConstants(self::calledClass());
    }

    /**
     * Get class constant by value.
     *
     * @param mixed $value
     * @return string
     */
    private static function getClassConstantByValue($value): ?string
    {
        return array_search($value, self::getClassConstants()) ?: null;
    }

    /**
     * Get public class constants.
     *
     * @return string[]
     */
    private static function getPublicClassConstants(): array
    {
        return Obj::getPublicConstants(self::calledClass());
    }

    /**
     * Get public class constant by value.
     *
     * @param mixed $value
     * @return string
     */
    private static function getPublicClassConstantByValue($value): ?string
    {
        return array_search($value, self::getPublicClassConstants()) ?: null;
    }

    /**
     * Get private class constants.
     *
     * @return string[]
     */
    private static function getPrivateClassConstants(): array
    {
        return Obj::getPrivateConstants(self::calledClass());
    }

    /**
     * Get private class constant by value.
     *
     * @param mixed $value
     * @return string
     */
    private static function getPrivateClassConstantByValue($value): ?string
    {
        return array_search($value, self::getPrivateClassConstants()) ?: null;
    }

    /**
     * Has class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private static function hasClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys(self::getClassConstants()));
    }

    /**
     * Has class constant by value.
     *
     * @param mixed $value
     * @return bool
     */
    private static function hasClassConstantByValue($value): bool
    {
        $constant = self::getClassConstantByValue($value);
        if ($constant !== null) {
            return self::hasClassConstant($constant);
        }

        return false;
    }

    /**
     * Has public class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private static function hasPublicClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys(self::getPublicClassConstants()));
    }

    /**
     * Has public class constant by value.
     *
     * @param mixed $value
     * @return bool
     */
    private static function hasPublicClassConstantByValue($value): bool
    {
        $constant = self::getPublicClassConstantByValue($value);
        if ($constant !== null) {
            return self::hasPublicClassConstant($constant);
        }

        return false;
    }

    /**
     * Has private class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private static function hasPrivateClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys(self::getPrivateClassConstants()));
    }

    /**
     * Has private class constant by value.
     *
     * @param mixed $value
     * @return bool
     */
    private static function hasPrivateClassConstantByValue($value): bool
    {
        $constant = self::getPrivateClassConstantByValue($value);
        if ($constant !== null) {
            return self::hasPrivateClassConstant($constant);
        }

        return false;
    }

    /**
     * Called class.
     *
     * @return string
     */
    private static function calledClass(): string
    {
        return get_called_class();
    }
}