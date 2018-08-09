<?php

namespace CoRex\Helpers\Traits;

use CoRex\Helpers\Arr;

trait DataTrait
{
    private $data = [];

    /**
     * Clear data.
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Set array.
     *
     * @param array $data
     * @param boolean $doMerge
     * @return $this
     */
    public function setArray(array $data, $doMerge = false)
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
     * @return boolean
     */
    public function has($key)
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
    public function get($key, $default = null)
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
    public function set($key, $value)
    {
        Arr::set($this->data, $key, $value, true);
        return $this;
    }

    /**
     * Get int.
     *
     * @param string $key
     * @param integer $default
     * @return integer
     */
    public function getInt($key, $default = 0)
    {
        return intval($this->get($key, $default));
    }

    /**
     * Set int.
     *
     * @param string $key
     * @param integer $value
     * @return $this
     */
    public function setInt($key, $value)
    {
        $this->set($key, intval($value));
        return $this;
    }

    /**
     * Get bool (translate: 1, true, '1', 'true', 'yes', 'on'). Otherwise false.
     *
     * @param string $key
     * @param boolean $default
     * @return boolean
     */
    public function getBool($key, $default = false)
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
     * @param boolean $value Supported values: 1, true, '1', 'true', 'yes', 'on'. Otherwise false.
     * @return $this
     */
    public function setBool($key, $value)
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
    public function setNull($key)
    {
        $this->set($key, null);
    }

    /**
     * Remove.
     *
     * @param string $key
     * @return $this
     */
    public function remove($key)
    {
        $this->data = Arr::remove($this->data, $key);
        return $this;
    }

    /**
     * All.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}