<?php

declare(strict_types=1);

namespace CoRex\Helpers;

class Is
{
    /**
     * Tests weather a string is camel case or not.
     *
     * @param string $value
     * @return bool
     */
    public static function camelCase(string $value): bool
    {
        return $value === Str::camelCase($value);
    }

    /**
     * Tests weather a string is snake case or not.
     *
     * @param string $value
     * @return bool
     */
    public static function kebabCase(string $value): bool
    {
        return $value === Str::kebabCase($value);
    }

    /**
     * Tests weather a string is pascal case or not.
     *
     * @param string $value
     * @return bool
     */
    public static function pascalCase(string $value): bool
    {
        return $value === Str::pascalCase($value);
    }

    /**
     * Tests weather a string is snake case or not.
     *
     * @param string $value
     * @return bool
     */
    public static function snakeCase(string $value): bool
    {
        return $value === Str::snakeCase($value, true);
    }

    /**
     * Is date (YYYY-MM-DD / Y-m-d).
     *
     * @param string $value
     * @return bool
     */
    public static function date(string $value): bool
    {
        $matches = preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value);
        return is_int($matches) && $matches > 0;
    }

    /**
     * Is time (HH:MM:SS / H:i:s).
     *
     * @param string $value
     * @return bool
     */
    public static function time(string $value): bool
    {
        $matches = preg_match('/^(\d{2}):(\d{2}):(\d{2})$/', $value);
        return is_int($matches) && $matches > 0;
    }

    /**
     * Is datetime (YYYY-MM-DD HH:MM:SS / Y-m-d H:i:s).
     *
     * @param string $value
     * @return bool
     */
    public static function datetime(string $value): bool
    {
        $matches = preg_match('/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/', $value);
        return is_int($matches) && $matches > 0;
    }

    /**
     * Is email.
     *
     * @param string $value
     * @return bool
     */
    public static function email(string $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_EMAIL);
        return is_string($result) && $value === $result;
    }

    /**
     * Is url.
     *
     * @param string $value
     * @return bool
     */
    public static function url(string $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_URL);
        return is_string($result) && $value === $result;
    }

    /**
     * Is ip.
     *
     * @param string $value
     * @return bool
     */
    public static function ip(string $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_IP);
        return is_string($result) && $value === $result;
    }

    /**
     * Is mac-address.
     *
     * @param string $value
     * @return bool
     */
    public static function macAddress(string $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_MAC);
        return is_string($result) && $value === $result;
    }

    /**
     * Is timezone.
     *
     * @param string $value
     * @return bool
     */
    public static function timezone(string $value): bool
    {
        return in_array($value, timezone_identifiers_list());
    }
}
