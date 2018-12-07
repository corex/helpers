<?php

declare(strict_types=1);

namespace CoRex\Helpers;

class Bag
{
    /** @var mixed[] */
    private $properties;

    /**
     * Bag.
     *
     * @param mixed $properties
     */
    public function __construct($properties = null)
    {
        $this->clear($properties);
    }

    /**
     * Clear.
     *
     * @param mixed $properties
     */
    public function clear($properties = null): void
    {
        $this->properties = [];
        if ($properties === null) {
            $properties = [];
        }
        foreach ($properties as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Check if key exist.
     *
     * @param string $key Uses dot notation.
     * @return bool
     */
    public function has(string $key): bool
    {
        $key = $this->prepareKey($key);
        return Arr::has($this->properties, $key);
    }

    /**
     * Set key/value.
     *
     * @param string $key Uses dot notation.
     * @param mixed $value
     * @param bool $create Default false.
     */
    public function set(string $key, $value, $create = false): void
    {
        $key = $this->prepareKey($key);
        Arr::set($this->properties, $key, $value, $create);
    }

    /**
     * Set array (merged by key).
     *
     * @param mixed[] $data
     * @param bool $create Default false.
     */
    public function setArray(array $data, bool $create = false): void
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value, $create);
        }
    }

    /**
     * Get value.
     *
     * @param string $key Uses dot notation.
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get(string $key, $defaultValue = null)
    {
        $key = $this->prepareKey($key);
        return Arr::get($this->properties, $key, $defaultValue);
    }

    /**
     * Remove$key.
     *
     * @param string $key Uses dot notation.
     */
    public function remove(string $key): void
    {
        $key = $this->prepareKey($key);
        $this->properties = Arr::remove($this->properties, $key);
    }

    /**
     * Keys.
     *
     * @return string[]
     */
    public function keys(): array
    {
        return array_keys($this->all());
    }

    /**
     * All.
     *
     * @return mixed[]
     */
    public function all(): array
    {
        return (array)$this->properties;
    }

    /**
     * Prepare key.
     *
     * @param string $key
     * @return string
     */
    protected function prepareKey(string $key): string
    {
        return $key;
    }
}