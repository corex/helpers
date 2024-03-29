<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers;

use CoRex\Helpers\StrList;
use PHPUnit\Framework\TestCase;

class StrListTest extends TestCase
{
    private string $item1 = 'Item 1';
    private string $item2 = 'Item 2';
    private string $item3 = 'Item 3';
    private string $item4 = 'Item 4';
    private string $items;

    /**
     * Test count.
     */
    public function testCount(): void
    {
        $this->assertSame(3, StrList::count($this->items, '|'));
    }

    /**
     * Test count empty.
     */
    public function testCountEmpty(): void
    {
        $this->assertSame(0, StrList::count('', '|'));
    }

    /**
     * Test add.
     */
    public function testAdd(): void
    {
        $this->assertSame(3, StrList::count($this->items, '|'));
        $items = StrList::add($this->items, $this->item4, '|');
        $this->assertSame(4, StrList::count($items, '|'));
        $this->assertSame($this->items . '|' . $this->item4, $items);
    }

    /**
     * Test get.
     */
    public function testGet(): void
    {
        $this->assertSame($this->item3, StrList::get($this->items, 2, '|'));
    }

    /**
     * Test get tag.
     */
    public function testGetTag(): void
    {
        $this->assertSame('3', StrList::get('-1-|-2-|-3-|-4-', 2, '|', '-'));
    }

    /**
     * Test get empty.
     */
    public function testGetEmpty(): void
    {
        $this->assertSame('', StrList::get('', 2, '|'));
    }

    /**
     * Test pos.
     */
    public function testPos(): void
    {
        $this->assertSame(2, StrList::pos($this->items, $this->item3, '|'));
    }

    /**
     * Test pos empty.
     */
    public function testPosEmpty(): void
    {
        $this->assertSame(-1, StrList::pos('', $this->item3, '|'));
    }

    /**
     * Test remove.
     */
    public function testRemove(): void
    {
        $items = $this->items . '|' . $this->item4;
        $this->assertSame($this->items, StrList::remove($items, $this->item4, '|'));
    }

    /**
     * Test remove index.
     */
    public function testRemoveIndex(): void
    {
        $items = $this->items . '|' . $this->item4;
        $this->assertSame($this->items, StrList::removeIndex($items, 3, '|'));
    }

    /**
     * Test exist.
     */
    public function testExist(): void
    {
        $this->assertTrue(StrList::exist($this->items, $this->item2, '|'));
        $this->assertFalse(StrList::exist($this->items, $this->item4, '|'));
    }

    /**
     * Test merge.
     */
    public function testMerge(): void
    {
        $items1 = $this->item2 . '|' . $this->item1;
        $items2 = $this->item4 . '|' . $this->item3;
        $items = StrList::merge($items1, $items2, false, '|');
        $this->assertNotSame($this->items . '|' . $this->item4, $items);
        $items = StrList::merge($items1, $items2, true, '|');
        $this->assertSame($this->items . '|' . $this->item4, $items);
    }

    /**
     * Test merge sort.
     */
    public function testMergeSort(): void
    {
        $items1 = $this->item2 . '|' . $this->item1;
        $items2 = $this->item4 . '|' . $this->item3;
        $items = StrList::merge($items1, $items2, true, '|');
        $checkItems = [$this->item1, $this->item2, $this->item3, $this->item4];
        $this->assertSame(implode('|', $checkItems), $items);
    }

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->items = $this->item1 . '|' . $this->item2 . '|' . $this->item3;
    }
}
