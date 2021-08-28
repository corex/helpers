<?php

declare(strict_types=1);

namespace CoRex\Helpers\Traits;

use CoRex\Helpers\Arr;

trait DataPrivateTrait
{
    /** @var mixed[] */
    private array $dataPrivate = [];

    /**
     * Data private clear.
     */
    private function dataPrivateClear(): void
    {
        $this->dataPrivate = [];
    }

    /**
     * Data private set.
     *
     * @param string $key
     * @param mixed $value
     */
    private function dataPrivateSet(string $key, $value): void
    {
        Arr::set($this->dataPrivate, $key, $value, true);
    }

    /**
     * Data private set array.
     *
     * @param mixed[] $values
     */
    private function dataPrivateSetArray(array $values): void
    {
        foreach ($values as $key => $value) {
            $this->dataPrivateSet($key, $value);
        }
    }

    /**
     * Data private get value or null.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    private function dataPrivateGet(string $key, $default = null)
    {
        return Arr::get($this->dataPrivate, $key, $default);
    }

    /**
     * Data private set string.
     *
     * @param string $key
     * @param mixed $value
     */
    private function dataPrivateSetString(string $key, $value): void
    {
        $this->dataPrivateSet($key, (string)$value);
    }

    /**
     * Data private get value as string or null.
     *
     * @param string $key
     * @param mixed|null $default
     * @return string|null
     */
    private function dataPrivateGetStringNull(string $key, $default = null): ?string
    {
        $value = $this->dataPrivateGet($key, $default);
        if ($value !== null) {
            $value = (string)$value;
        }

        return $value;
    }

    /**
     * Data private get value as string.
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    private function dataPrivateGetString(string $key, string $default = ''): string
    {
        return (string)$this->dataPrivateGet($key, $default);
    }

    /**
     * Data private set int.
     *
     * @param string $key
     * @param int $value
     * @return $this
     */
    private function dataPrivateSetInt(string $key, int $value): self
    {
        $this->dataPrivateSet($key, intval($value));

        return $this;
    }

    /**
     * Data private get as int or null.
     *
     * @param string $key
     * @param int|null $default
     * @return int|null
     */
    private function dataPrivateGetIntNull(string $key, ?int $default = null): ?int
    {
        $value = $this->dataPrivateGet($key, $default);
        if ($value !== null) {
            $value = intval($value);
        }

        return $value;
    }

    /**
     * Data private get as int.
     *
     * @param string $key
     * @param int $default
     * @return int
     */
    private function dataPrivateGetInt(string $key, int $default = 0): int
    {
        return intval($this->dataPrivateGet($key, $default));
    }

    /**
     * Data private set bool.
     *
     * @param string $key
     * @param mixed $value Supported values: 1, true, '1', 'true', 'yes', 'on'. Otherwise false.
     * @return $this
     */
    private function dataPrivateSetBool(string $key, $value)
    {
        if (is_string($value)) {
            $value = strtolower($value);
        }

        $this->dataPrivateSet($key, in_array($value, [1, true, '1', 'true', 'yes', 'on'], true));

        return $this;
    }

    /**
     * Data private get as bool or null.
     *
     * @param string $key
     * @param bool|null $default
     * @return bool|null
     */
    private function dataPrivateGetBoolNull(string $key, ?bool $default = null): ?bool
    {
        $value = $this->dataPrivateGet($key, $default);
        if ($value !== null) {
            $value = in_array($value, ['true', true, 'yes', 'on', 1, '1'], true);
        }

        return $value;
    }

    /**
     * Data private get as bool.
     *
     * @param string $key
     * @param bool $default
     * @return bool
     */
    private function dataPrivateGetBool(string $key, bool $default = false): bool
    {
        return (bool)$this->dataPrivateGetBoolNull($key, $default);
    }

    /**
     * Data private set null.
     *
     * @param string $key
     */
    private function dataPrivateSetNull(string $key): void
    {
        $this->dataPrivateSet($key, null);
    }

    /**
     * Data private has.
     *
     * @param string $key
     * @return bool
     */
    private function dataPrivateHas(string $key): bool
    {
        return Arr::has($this->dataPrivate, $key);
    }

    /**
     * Data private remove.
     *
     * @param string $key
     */
    private function dataPrivateRemove(string $key): void
    {
        $this->dataPrivate = Arr::remove($this->dataPrivate, $key);
    }

    /**
     * Data private all.
     *
     * @return mixed[]
     */
    private function dataPrivateAll(): array
    {
        return $this->dataPrivate;
    }
}