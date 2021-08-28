<?php

declare(strict_types=1);

namespace CoRex\Helpers;

class StrList
{
    /**
     * Count.
     *
     * @param string $list
     * @param string $separator
     * @return int
     */
    public static function count(string $list, string $separator): int
    {
        return count(self::explode($separator, $list));
    }

    /**
     * Add.
     *
     * @param string $list
     * @param string $item
     * @param string $separator
     * @param string $tag Default ''.
     * @return string
     */
    public static function add(string $list, string $item, string $separator, string $tag = ''): string
    {
        $items = self::explode($separator, $list);
        if (!in_array($tag . $item . $tag, $items, true)) {
            $items[] = $tag . $item . $tag;
        }

        return implode($separator, $items);
    }

    /**
     * Get.
     *
     * @param string $list
     * @param string|int $index
     * @param string $separator
     * @param string $tag Default ''.
     * @return string
     */
    public static function get(string $list, $index, string $separator, string $tag = ''): string
    {
        $items = self::explode($separator, $list);
        if (isset($items[$index])) {
            $item = $items[$index];
            if ($tag !== '' && substr($item, 0, 1) === $tag && substr($item, -1) === $tag) {
                $item = substr($item, 1, -1);
            }

            return $item;
        }

        return '';
    }

    /**
     * Pos.
     *
     * @param string $list
     * @param string $item
     * @param string $separator
     * @param string $tag Default ''.
     * @return int
     */
    public static function pos(string $list, string $item, string $separator, string $tag = ''): int
    {
        $items = self::explode($separator, $list);
        $pos = array_search($tag . $item . $tag, $items, true);
        if ($pos === false) {
            $pos = -1;
        }

        return $pos;
    }

    /**
     * Remove.
     *
     * @param string $list
     * @param string $item
     * @param string $separator
     * @param string $tag Default ''.
     * @return string
     */
    public static function remove(string $list, string $item, string $separator, string $tag = ''): string
    {
        $items = self::explode($separator, $list);
        $pos = self::pos($list, $item, $separator, $tag);
        if ($pos > -1 && isset($items[$pos])) {
            unset($items[$pos]);
        }

        return implode($separator, $items);
    }

    /**
     * Remove index.
     *
     * @param string $list
     * @param string|int $index
     * @param string $separator
     * @return string
     */
    public static function removeIndex(string $list, $index, string $separator): string
    {
        $items = self::explode($separator, $list);
        if (isset($items[$index])) {
            unset($items[$index]);
        }

        return implode($separator, $items);
    }

    /**
     * Exist.
     *
     * @param string $list
     * @param string $item
     * @param string $separator
     * @param string $tag Default ''.
     * @return bool
     */
    public static function exist(string $list, string $item, string $separator, string $tag = ''): bool
    {
        $items = self::explode($separator, $list);

        return in_array($tag . $item . $tag, $items, true);
    }

    /**
     * Merge.
     *
     * @param string $list1
     * @param string $list2
     * @param bool $sort Default false.
     * @param string $separator
     * @return string
     */
    public static function merge(string $list1, string $list2, bool $sort, string $separator): string
    {
        $items1 = self::explode($separator, $list1);
        $items2 = self::explode($separator, $list2);
        if (count($items2) > 0) {
            foreach ($items2 as $item) {
                if (!in_array($item, $items1, true)) {
                    $items1[] = $item;
                }
            }
        }

        if ($sort) {
            sort($items1);
        }

        return implode($separator, $items1);
    }

    /**
     * Explode.
     *
     * @param string $separator
     * @param string $list
     * @return string[]
     */
    private static function explode(string $separator, string $list): array
    {
        if ($list !== '') {
            return explode($separator, $list);
        }

        return [];
    }
}