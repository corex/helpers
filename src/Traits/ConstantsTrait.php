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
     * Get public class constants.
     *
     * @return string[]
     */
    private function getPublicClassConstants(): array
    {
        return Obj::getPublicConstants($this);
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
     * Has class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private function hasClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys($this->getClassConstants()));
    }

    /**
     * Has public class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private function hasPublicClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys($this->getPublicClassConstants()));
    }

    /**
     * Has private class constant.
     *
     * @param string $constantName
     * @return bool
     */
    private function hasPrivateClassConstant(string $constantName): bool
    {
        return in_array($constantName, array_keys($this->getPrivateClassConstants()));
    }
}