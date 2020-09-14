<?php

declare(strict_types=1);

namespace CoRex\Helpers;

class Arr
{
    /**
     * Get value from data.
     *
     * @param mixed[] $data
     * @param string $key Uses dot notation.
     * @param mixed $defaultValue Default null.
     * @return mixed|null
     */
    public static function get(array $data, string $key, $defaultValue = null)
    {
        $data = self::dataByPath($data, $key);
        if ($data === null) {
            $data = $defaultValue;
        }

        return $data;
    }

    /**
     * Set value in data.
     *
     * @param mixed[] $array
     * @param string $key Uses dot notation.
     * @param mixed $value
     * @param bool $create Default false.
     */
    public static function set(array &$array, string $key, $value, bool $create = false): void
    {
        // Extract key/path.
        $keyLast = Str::last($key, '.');
        $key = Str::removeLast($key, '.');

        // Extract data.
        if ($key !== '' && $key !== null) {
            $array = &self::dataByPath($array, $key, $create);
        }

        if ($array !== null || $create) {
            $array[$keyLast] = $value;
        }
    }

    /**
     * Has.
     *
     * @param mixed[] $array
     * @param string $key Uses dot notation.
     * @return bool
     */
    public static function has(array $array, string $key): bool
    {
        $check = self::dataByPath($array, $key, false, 'not.found');

        return $check !== 'not.found';
    }

    /**
     * Get first element of array.
     *
     * @param mixed[] $data
     * @param string|null $key Get key from element if array. Default null.
     * @return mixed
     */
    public static function first(array $data, ?string $key = null)
    {
        if (count($data) === 0) {
            return null;
        }

        reset($data);
        $element = current($data);
        if ($key !== null && is_array($element) && isset($element[$key])) {
            return $element[$key];
        }

        return $element;
    }

    /**
     * Get last element of array.
     *
     * @param mixed[] $data
     * @param string|null $key Get key from element if array. Default null.
     * @return mixed
     */
    public static function last(array $data, ?string $key = null)
    {
        if (count($data) === 0) {
            return null;
        }

        $element = end($data);
        if ($key !== null && is_array($element) && isset($element[$key])) {
            return $element[$key];
        }

        return $element;
    }

    /**
     * Remove.
     *
     * @param mixed[] $array
     * @param string $key Uses dot notation.
     * @return mixed[]
     */
    public static function remove(array $array, string $key): array
    {
        // Extract key/path.
        $keyLast = Str::last($key, '.');
        $key = Str::removeLast($key, '.');

        // If found, remove element.
        $arrayElement = &self::dataByPath($array, $key, false, 'not.found');
        if ($arrayElement !== 'not.found') {
            if (array_key_exists($keyLast, $arrayElement)) {
                unset($arrayElement[$keyLast]);
            }
        }

        return $array;
    }

    /**
     * Remote first element of array.
     *
     * @param mixed[] $data
     * @return mixed[]
     */
    public static function removeFirst(array $data): array
    {
        if (count($data) > 0) {
            array_shift($data);
        }

        return $data;
    }

    /**
     * Remove last element of array.
     *
     * @param mixed[] $data
     * @return mixed[]
     */
    public static function removeLast(array $data): array
    {
        if (count($data) > 0) {
            unset($data[count($data) - 1]);
        }

        return $data;
    }

    /**
     * Is list (0..n).
     *
     * @param mixed[] $data
     * @return bool
     */
    public static function isList(array $data): bool
    {
        $isList = true;
        if (count($data) > 0) {
            for ($c1 = 0; $c1 < count($data); $c1++) {
                if (!isset($data[$c1])) {
                    $isList = false;
                }
            }
        }

        return $isList;
    }

    /**
     * Is string in list.
     *
     * @param string[] $list
     * @param string|null $key Default null.
     * @return bool
     */
    public static function isStringInList(array $list, ?string $key = null): bool
    {
        $stringInList = false;
        if (count($list) === 0) {
            return $stringInList;
        }

        foreach ($list as $item) {
            if ($key !== null && isset($item[$key])) {
                $value = $item[$key];
            } else {
                $value = $item;
            }

            if (!is_numeric($value)) {
                $stringInList = true;
            }
        }

        return $stringInList;
    }

    /**
     * Index of.
     * Note: Supports array with objects.
     *
     * @param string[] $array
     * @param string $value
     * @param string|null $key Default null which means the item itself (not associative array).
     * @return int|string -1 if not found.
     */
    public static function indexOf(array $array, string $value, ?string $key = null)
    {
        foreach ($array as $index => $item) {
            if ($key !== null) {
                if (is_object($item)) {
                    $checkValue = isset($item->{$key}) ? $item->{$key} : null;
                } else {
                    $checkValue = isset($item[$key]) ? $item[$key] : null;
                }
            } else {
                $checkValue = $item;
            }

            if ($checkValue !== null && $checkValue === $value) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * Check if all keys exist in array.
     *
     * @param mixed[] $data
     * @param string[] $keys
     * @return bool
     */
    public static function keysExist(array $data, array $keys): bool
    {
        if (count($keys) > 0) {
            foreach ($keys as $key) {
                if (!array_key_exists($key, $data)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Keys.
     *
     * @param mixed[] $array
     * @return string[]
     */
    public static function keys(array $array): array
    {
        return array_keys($array);
    }

    /**
     * Values (0..n).
     *
     * @param mixed[] $array
     * @return mixed[]
     */
    public static function values(array $array): array
    {
        return array_values($array);
    }

    /**
     * Is associative.
     *
     * @param mixed[] $array
     * @return bool
     */
    public static function isAssociative(array $array): bool
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    /**
     * Pluck.
     *
     * @param mixed $array
     * @param string $key Uses dot notation.
     * @param mixed $defaultValue Default null.
     * @return mixed[]
     */
    public static function pluck($array, string $key, $defaultValue = null): array
    {
        $result = [];
        if (!is_array($array)) {
            return $result;
        }

        // Extract key/path.
        $keyLast = Str::last($key, '.');
        $key = Str::removeLast($key, '.');

        // Extract data.
        if ($key !== '' && $key !== null) {
            $array = self::dataByPath($array, $key, false, []);
        }

        foreach ($array as $item) {
            $value = $defaultValue;
            if (is_object($item) && isset($item->{$keyLast})) {
                $value = $item->{$keyLast};
            } elseif (is_array($item) && isset($item[$keyLast])) {
                $value = $item[$keyLast];
            }

            $result[] = $value;
        }

        return $result;
    }

    /**
     * Get line match.
     *
     * @param string[] $lines
     * @param string $prefix
     * @param string $suffix
     * @param bool $doTrim
     * @param bool $removePrefixSuffix Default false.
     * @return string[]
     */
    public static function lineMatch(
        array $lines,
        string $prefix,
        string $suffix,
        bool $doTrim,
        bool $removePrefixSuffix = false
    ): array {
        $result = [];
        foreach ($lines as $line) {
            $isHit = true;
            if ($prefix !== '' && $prefix !== null && Str::startsWith(trim($line), $prefix)) {
                if ($removePrefixSuffix) {
                    $line = substr(trim($line), strlen($prefix));
                }
            } else {
                $isHit = false;
            }

            if ($suffix !== '' && $suffix !== null && Str::endsWith(trim($line), $suffix)) {
                if ($removePrefixSuffix) {
                    $line = substr(trim($line), 0, -strlen($suffix));
                }
            } else {
                $isHit = false;
            }

            if ($isHit) {
                if ($doTrim) {
                    $line = trim($line);
                }

                $result[] = $line;
            }
        }

        return $result;
    }

    /**
     * To array.
     *
     * @param mixed $stringOrArray
     * @param string $separator Default '.'.
     * @return mixed[]
     */
    public static function toArray($stringOrArray, string $separator = '.'): array
    {
        if (is_string($stringOrArray)) {
            if (trim($stringOrArray) !== '') {
                $stringOrArray = explode($separator, $stringOrArray);
            }
        }

        if (!is_array($stringOrArray)) {
            return [];
        }

        return $stringOrArray;
    }

    /**
     * To json.
     *
     * @param mixed[] $array
     * @param bool $prettyPrint
     * @param bool $unescapedSlashes
     * @return string
     */
    public static function toJson(array $array, bool $prettyPrint = true, bool $unescapedSlashes = true): string
    {
        $options = 0;
        if ($unescapedSlashes) {
            $options += JSON_UNESCAPED_SLASHES;
        }

        if ($prettyPrint) {
            $options += JSON_PRETTY_PRINT;
        }

        return json_encode($array, $options);
    }

    /**
     * Get data by path.
     *
     * @param mixed[] $data
     * @param string $key Uses dot notation.
     * @param bool $create Default false.
     * @param mixed $defaultValue Default null.
     * @return mixed
     */
    private static function &dataByPath(array &$data, string $key, bool $create = false, $defaultValue = null)
    {
        if ($key === '') {
            return $data;
        }

        $pathSegments = explode('.', $key);
        foreach ($pathSegments as $pathSegment) {
            if (!is_array($data)) {
                $data = [];
            }

            if (!array_key_exists($pathSegment, $data) && !$create) {
                return $defaultValue;
            }

            $data = &$data[$pathSegment];
        }

        return $data;
    }
}