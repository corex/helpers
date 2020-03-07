<?php

declare(strict_types=1);

namespace CoRex\Helpers\Traits;

use CoRex\Helpers\Arr;

trait DataTrait
{
    /** @var mixed[] */
    private $data = [];

    /**
     * Clear data.
     */
    public function clear(): void
    {
        $this->data = [];
    }

    /**
     * Set array.
     *
     * @param mixed[] $data
     * @param bool $doMerge
     * @return $this
     */
    public function setArray(array $data, bool $doMerge = false): self
    {
        if ($doMerge) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        } else {
            $this->data = $data;
        }

        return $this;
    }

    /**
     * Has.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Get.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Set.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value): self
    {
        Arr::set($this->data, $key, $value, true);

        return $this;
    }

    /**
     * Get int.
     *
     * @param string $key
     * @param int $default
     * @return int
     */
    public function getInt(string $key, int $default = 0): int
    {
        return intval($this->get($key, $default));
    }

    /**
     * Set int.
     *
     * @param string $key
     * @param int $value
     * @return $this
     */
    public function setInt(string $key, int $value): self
    {
        $this->set($key, intval($value));

        return $this;
    }

    /**
     * Get bool (translate: 1, true, '1', 'true', 'yes', 'on'). Otherwise false.
     *
     * @param string $key
     * @param bool $default
     * @return bool
     */
    public function getBool(string $key, bool $default = false): bool
    {
        $value = $this->get($key, $default);
        if (is_string($value)) {
            $value = strtolower($value);
        }

        return in_array($value, [1, true, '1', 'true', 'yes', 'on'], true);
    }

    /**
     * Set bool.
     *
     * @param string $key
     * @param mixed $value Supported values: 1, true, '1', 'true', 'yes', 'on'. Otherwise false.
     * @return $this
     */
    public function setBool(string $key, $value)
    {
        if (is_string($value)) {
            $value = strtolower($value);
        }

        $this->set($key, in_array($value, [1, true, '1', 'true', 'yes', 'on'], true));

        return $this;
    }

    /**
     * Set null.
     *
     * @param string $key
     */
    public function setNull(string $key): void
    {
        $this->set($key, null);
    }

    /**
     * Remove.
     *
     * @param string $key
     * @return $this
     */
    public function remove(string $key): self
    {
        $this->data = Arr::remove($this->data, $key);

        return $this;
    }

    /**
     * All.
     *
     * @return mixed[]
     */
    public function all(): array
    {
        return $this->data;
    }
}