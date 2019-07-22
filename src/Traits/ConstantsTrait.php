<?php

declare(strict_types=1);

namespace CoRex\Helpers\Traits;

use CoRex\Helpers\Obj;

trait ConstantsTrait
{
    /**
     * Get class constants.
     *
     * @return string[]
     */
    private function getClassConstants(): array
    {
        return Obj::getConstants($this);
    }

    /**
     * Get class constant by value.
     *
     * @param mixed $value
     * @return string
     */
    private function getClassConstantByValue($value): ?string
    {
        return array_search($value, $this->getClassConstants(), true) ?: null;
    }

    /**
     * Get public class constants.
     *
     * @return string[]
     */
    private function getPublicClassConstants(): array
    {
        return Obj::getPublicConstants($this);
    }

    /**
     * Get public class constant by value.
     *
     * @param mixed $value
     * @return string
     */
    private function getPublicClassConstantByValue($value): ?string
    {
        return array_search($value, $this->getPublicClassConstants(), true) ?: null;
    }

    /**
     * Get private class constants.
     *
     * @return string[]
     */
    private function getPrivateClassConstants(): array
    {
        return Obj::getPrivateConstants($this);
    }

    /**
     * Get private class constant by value.
     *
     * @param mixed $value
     * @return string
     */
    private function getPrivateClassConstantByValue($value): ?string
    {
        return array_search($value, $this->getPrivateClassConstants(), true) ?: null;
    }

    /**
     * Has class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private function hasClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys($this->getClassConstants()), true);
    }

    /**
     * Has class constant by value.
     *
     * @param mixed $value
     * @return bool
     */
    private function hasClassConstantByValue($value): bool
    {
        $constant = $this->getClassConstantByValue($value);
        if ($constant !== null) {
            return $this->hasClassConstant($constant);
        }
        return false;
    }

    /**
     * Has public class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private function hasPublicClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys($this->getPublicClassConstants()), true);
    }

    /**
     * Has public class constant by value.
     *
     * @param mixed $value
     * @return bool
     */
    private function hasPublicClassConstantByValue($value): bool
    {
        $constant = $this->getPublicClassConstantByValue($value);
        if ($constant !== null) {
            return $this->hasPublicClassConstant($constant);
        }
        return false;
    }

    /**
     * Has private class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private function hasPrivateClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys($this->getPrivateClassConstants()), true);
    }

    /**
     * Has private class constant by value.
     *
     * @param mixed $value
     * @return bool
     */
    private function hasPrivateClassConstantByValue($value): bool
    {
        $constant = $this->getPrivateClassConstantByValue($value);
        if ($constant !== null) {
            return $this->hasPrivateClassConstant($constant);
        }
        return false;
    }
}