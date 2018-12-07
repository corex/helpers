<?php

declare(strict_types=1);

namespace CoRex\Helpers;

class Str
{
    public const LIMIT_SUFFIX = '...';
    public const PASCALCASE = 'pascalCase';
    public const CAMELCASE = 'camelCase';
    public const SNAKECASE = 'snakeCase';
    public const KEBABCASE = 'kebabCase';

    /**
     * Get length of string.
     *
     * @param string $value
     * @return int
     */
    public static function length(string $value): int
    {
        return mb_strlen($value);
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param string $value
     * @return string
     */
    public static function lower(string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param string $value
     * @return string
     */
    public static function upper(string $value): string
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Returns the portion of string specified by the start and length parameters.
     *
     * @param string $string
     * @param int $start
     * @param int|null $length Default null.
     * @return string
     */
    public static function substr(string $string, int $start, ?int $length = null): string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Left.
     *
     * @param string $string
     * @param int $count
     * @return string
     */
    public static function left(string $string, int $count): string
    {
        return self::substr($string, 0, $count);
    }

    /**
     * Right.
     *
     * @param string $string
     * @param int $count
     * @return string
     */
    public static function right(string $string, int $count): string
    {
        return self::substr($string, -$count);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string $haystack
     * @param  string $needle
     * @return bool
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return static::isPrefixed($haystack, $needle);
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string $haystack
     * @param  string $needle
     * @return bool
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return static::isSuffixed($haystack, $needle);
    }

    /**
     * Make a string's first character uppercase.
     *
     * @param  string $string
     * @return string
     */
    public static function ucfirst(string $string): string
    {
        return static::upper(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Make a string's first character lowercase.
     *
     * @param string $string
     * @return string
     */
    public static function lcfirst(string $string): string
    {
        return static::lower(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param string $value
     * @param int $limit Default 50.
     * @param string $end Default '...'.
     * @return string
     */
    public static function limit(string $value, int $limit = 50, string $end = self::LIMIT_SUFFIX): string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }

    /**
     * Is prefixed.
     *
     * @param string $data
     * @param string $prefix
     * @param string $separator Default ''.
     * @return bool
     */
    public static function isPrefixed(string $data, string $prefix, string $separator = ''): bool
    {
        if ($separator !== '') {
            $data = trim($data, $separator);
        }
        return static::substr($data, 0, static::length($prefix)) === $prefix;
    }

    /**
     * Strip prefix.
     *
     * @param string $data
     * @param string $prefix
     * @param string $separator Default ''.
     * @return string
     */
    public static function stripPrefix(string $data, string $prefix, string $separator = ''): string
    {
        if ($data === '') {
            return $data;
        }
        if ($separator !== '') {
            $data = ltrim($data, $separator);
        }
        if (static::substr($data, 0, static::length($prefix)) === $prefix) {
            $data = static::substr($data, static::length($prefix));
        }
        if ($separator !== '') {
            $data = ltrim($data, $separator);
        }
        return $data;
    }

    /**
     * Force prefix.
     *
     * @param string $data
     * @param string $prefix
     * @param string $separator Default ''.
     * @return string
     */
    public static function forcePrefix(string $data, string $prefix, string $separator = ''): string
    {
        if ($data === '') {
            return $data;
        }
        if ($separator !== '') {
            $data = trim($data, $separator);
        }
        if (static::substr($data, 0, static::length($prefix)) !== $prefix) {
            if ($separator !== '') {
                $prefix .= $separator;
            }
            $data = $prefix . $data;
        }
        return $data;
    }

    /**
     * Is suffixed.
     *
     * @param string $data
     * @param string $suffix
     * @param string $separator Default ''.
     * @return bool
     */
    public static function isSuffixed(string $data, string $suffix, string $separator = ''): bool
    {
        if ($separator !== '') {
            $data = trim($data, $separator);
        }
        return static::substr($data, -static::length($suffix)) === $suffix;
    }

    /**
     * Strip suffix.
     *
     * @param string $data
     * @param string $prefix
     * @param string $separator Default ''.
     * @return string
     */
    public static function stripSuffix(string $data, string $prefix, string $separator = ''): string
    {
        if ($data === '') {
            return $data;
        }
        if ($separator !== '') {
            $data = rtrim($data, $separator);
        }
        if (static::substr($data, -static::length($prefix)) === $prefix) {
            $data = static::substr($data, 0, -static::length($prefix));
        }
        if ($separator !== '') {
            $data = rtrim($data, $separator);
        }
        return $data;
    }

    /**
     * Force suffix.
     *
     * @param string $data
     * @param string $prefix
     * @param string $separator Default ''.
     * @return string
     */
    public static function forceSuffix(string $data, string $prefix, string $separator = ''): string
    {
        if ($data === '') {
            return $data;
        }
        if ($separator !== '') {
            $data = trim($data, $separator);
        }
        if (static::substr($data, -static::length($prefix)) !== $prefix) {
            if ($separator !== '') {
                $data .= $separator;
            }
            $data .= $prefix;
        }
        return $data;
    }

    /**
     * Replace token.
     * Token: '{something}'.
     *
     * @param string $string
     * @param string[] $data Must be specified as [$key => $value].
     * @return string
     */
    public static function replaceToken(string $string, array $data): string
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $string = str_replace('{' . $key . '}', $value, $string);
            }
        }
        return $string;
    }

    /**
     * Removed first entry based on $separator.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function removeFirst(string $string, string $separator): string
    {
        $string = explode($separator, $string);
        $string = Arr::removeFirst($string);
        return implode($separator, $string);
    }

    /**
     * Removed last entry based on $separator.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function removeLast(string $string, string $separator): string
    {
        $string = explode($separator, $string);
        $string = Arr::removeLast($string);
        return implode($separator, $string);
    }

    /**
     * Get first part of string based on $separator.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function first(string $string, string $separator): string
    {
        $string = explode($separator, $string);
        return Arr::first($string);
    }

    /**
     * Get last part of string based on $separator.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function last(string $string, string $separator): string
    {
        $string = explode($separator, $string);
        return Arr::last($string);
    }

    /**
     * Get part.
     *
     * @param string $string
     * @param string $separator
     * @param int $index
     * @param string $defaultValue Default ''.
     * @return string
     */
    public static function part(string $string, string $separator, int $index, string $defaultValue = ''): string
    {
        if ($string !== '') {
            $string = explode($separator, $string);
            if (isset($string[$index])) {
                return $string[$index];
            }
        }
        return $defaultValue;
    }

    /**
     * Get CSV fields. Removes ' and ".
     *
     * @param string $line
     * @param string $delimiter Default ','.
     * @return string[]
     */
    public static function csvFields(string $line, string $delimiter = ','): array
    {
        if (trim($line) === '') {
            return [];
        }
        $fields = [];
        $parts = str_getcsv($line, $delimiter);
        if ($parts !== null && count($parts) > 0) {
            foreach ($parts as $part) {
                $part = trim($part);
                if (substr($part, 0, 1) === '"' || substr($part, 0, 1) === '\'') {
                    $part = substr($part, 1);
                }
                if (substr($part, -1) === '"' || substr($part, -1) === '\'') {
                    $part = substr($part, 0, -1);
                }
                if ($part !== '') {
                    $fields[] = $part;
                }
            }
        }
        return $fields;
    }

    /**
     * Slug.
     * Standard separator characters '-', '_', ' ', '.'.
     *
     * @param string $string
     * @param string $separator Default '.'.
     * @return string
     */
    public static function slug(string $string, string $separator = '.'): string
    {
        // Make sure standard characters has been replaced to separator.
        $slug = str_replace(['-', '_', ' ', '.'], $separator, mb_strtolower($string));

        // Remove all "funny" characters.
        $slug = preg_replace('/[^a-z0-9' . preg_quote($separator) . ']/', '', $slug);

        return $slug;
    }

    /**
     * Split into key/value array.
     * Note: 'slice of' elements if keys and values are not the same length.
     *
     * @param string $string
     * @param string $separator
     * @param string[] $keys
     * @return string[]
     */
    public static function splitIntoKeyValue(string $string, string $separator, array $keys): array
    {
        $parts = explode($separator, $string);
        $result = [];
        if (count($keys) > 0) {

            // Make sure arrays has equal number of items.
            if (count($parts) > count($keys)) {
                $parts = array_slice($parts, 0, count($keys));
            }
            if (count($keys) > count($parts)) {
                $keys = array_slice($keys, 0, count($parts));
            }

            $result = array_combine($keys, $parts);
        }
        return $result;
    }

    /**
     * Create a unique string.
     *
     * @param string $prefix Default ''.
     * @param string $suffix Default ''.
     * @return string
     */
    public static function unique(string $prefix = '', string $suffix = ''): string
    {
        $unique = md5((string)mt_rand());
        if ($prefix !== '') {
            $unique = $prefix . $unique;
        }
        if ($suffix !== '') {
            $unique .= $suffix;
        }
        return $unique;
    }

    /**
     * Explode string into items.
     *
     * @param string $separator If "\n", "\r", will be removed before explode.
     * @param string $content
     * @param callable $itemFunction
     * @return string[]
     */
    public static function explode(string $separator, string $content, ?callable $itemFunction = null): array
    {
        if ($separator === "\n") {
            $content = str_replace("\r", '', $content);
        }
        $items = explode($separator, $content);
        if (is_callable($itemFunction)) {
            foreach ($items as $index => $item) {
                $items[$index] = $itemFunction($item);
            }
        }
        return $items;
    }

    /**
     * Implode items into string.
     *
     * @param string $separator
     * @param string[] $items
     * @param callable $itemFunction
     * @return string
     */
    public static function implode(string $separator, array $items, ?callable $itemFunction = null): string
    {
        if (is_callable($itemFunction)) {
            foreach ($items as $index => $item) {
                $items[$index] = $itemFunction($item);
            }
        }
        return implode($separator, $items);
    }

    /**
     * Pad left.
     *
     * @param string $string
     * @param int $length
     * @param string $filler Default ' '.
     * @return string
     */
    public static function padLeft(string $string, int $length, string $filler = ' '): string
    {
        while (self::length($string) <= ($length - self::length($filler))) {
            $string = $filler . $string;
        }
        return $string;
    }

    /**
     * Pad right.
     *
     * @param string $string
     * @param int $length
     * @param string $filler Default ' '.
     * @return string
     */
    public static function padRight(string $string, int $length, string $filler = ' '): string
    {
        while (self::length($string) <= ($length - self::length($filler))) {
            $string = $string . $filler;
        }
        return $string;
    }

    /**
     * Wrap.
     *
     * @param string $text
     * @param int $length
     * @param string $separator Default "\n".
     * @return string
     */
    public static function wrap(string $text, int $length, string $separator = "\n"): string
    {
        if ($text === '' || self::length($text) === $length) {
            return $text;
        }
        $endedWithLinebreak = substr($text, -1) === "\n";
        $text = str_replace("\r", '', $text);
        $text = str_replace("\n", '', $text);
        $text = explode(' ', $text);

        $result = [];
        $lineNo = 0;
        foreach ($text as $word) {
            if (!isset($result[$lineNo])) {
                $result[$lineNo] = '';
            }
            $lastLineNo = count($result) - 1;

            if ((self::length($result[$lastLineNo]) + self::length($word)) >= $length) {
                $lineNo++;
                if (!isset($result[$lineNo])) {
                    $result[$lineNo] = '';
                }
                $lastLineNo = count($result) - 1;
            }

            $result[$lastLineNo] .= $result[$lastLineNo] !== '' ? ' ' : '';
            $result[$lastLineNo] .= $word;
        }

        $text = implode($separator, $result);
        if ($endedWithLinebreak) {
            $text .= "\n";
        }
        return $text;
    }

    /**
     * Pascal case.
     *
     * @param string $value
     * @return string
     */
    public static function pascalCase(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return str_replace(' ', '', $value);
    }

    /**
     * Camel case.
     *
     * @param string $value
     * @return string
     */
    public static function camelCase(string $value): string
    {
        return lcfirst(static::pascalCase($value));
    }

    /**
     * Snake case.
     *
     * @param string $value
     * @param bool $toLowerCase Default false.
     * @param string $separator Default '_'.
     * @return string
     */
    public static function snakeCase(string $value, bool $toLowerCase = false, string $separator = '_'): string
    {
        $replace = strtolower(preg_replace(
            ['/\s+/', '/\s/', '/(?|([a-z\d])([A-Z])|([^\^])([A-Z][a-z]))/', '/[-_]+/'],
            [' ', $separator, '$1' . $separator . '$2', $separator],
            trim($value)
        ));
        return $toLowerCase ? strtolower($replace) : $replace;
    }

    /**
     * Kebab case.
     *
     * @param string $value
     * @param bool $toLowerCase Default true.
     * @return string
     */
    public static function kebabCase(string $value, bool $toLowerCase = true): string
    {
        return static::snakeCase($value, $toLowerCase, '-');
    }

    /**
     * Convert key case Recursively, using the method defined.
     *
     * @param string[] $array
     * @param string $method The Convention method to execute. Default pascal().
     * @param string $separator Default '_'.
     * @return mixed[]
     */
    public static function caseConvertArrayKeysRecursively(
        array $array,
        string $method = self::PASCALCASE,
        string $separator = '_'
    ): array {
        $return = [];
        foreach ($array as $key => $value) {
            if (!preg_match('/^\d+$/', $key)) {
                $key = self::$method(preg_replace('/\-/', '_', $key), true, $separator);
            }
            if (is_array($value)) {
                $value = self::caseConvertArrayKeysRecursively($value, $method);
            }
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * Get position in string.
     *
     * @param string $haystack
     * @param string $needle
     * @param int $offset
     * @return bool|false|int
     */
    public static function strpos(string $haystack, string $needle, int $offset = 0)
    {
        return mb_strpos($haystack, $needle, $offset, 'UTF-8');
    }

    /**
     * Index of.
     *
     * @param string $haystack
     * @param string $needle
     * @param int $offset
     * @return int
     */
    public static function indexOf(string $haystack, string $needle, int $offset = 0): int
    {
        $pos = self::strpos($haystack, $needle, $offset);
        return is_int($pos) ? $pos : -1;
    }

    /**
     * Contains.
     *
     * @param string $haystack
     * @param string $needle
     * @param int $offset
     * @return bool
     */
    public static function contains(string $haystack, string $needle, int $offset = 0): bool
    {
        return self::strpos($haystack, $needle, $offset) !== false;
    }
}