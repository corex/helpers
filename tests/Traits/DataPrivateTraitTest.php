<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Traits;

use CoRex\Helpers\Traits\DataPrivateTrait;
use PHPUnit\Framework\TestCase;

class DataPrivateTraitTest extends TestCase
{
    use DataPrivateTrait;

    private int $randomInt;
    private string $randomString;

    /**
     * Test dataPrivateClear().
     */
    public function testDataPrivateClear(): void
    {
        // Set data.
        $this->dataPrivateSet('mixed', 'something');
        $this->dataPrivateSetInt('value', 7);
        $this->dataPrivateSetBool('bool', true);

        // Check is set.
        $this->assertNotSame([], $this->dataPrivateAll());

        // Clear.
        $this->dataPrivateClear();

        // Check is not set.
        $this->assertSame([], $this->dataPrivateAll());
    }

    /**
     * Test dataPrivateSet().
     */
    public function testDataPrivateSet(): void
    {
        $this->dataPrivateSet('mixed', $this->randomString);
        $this->assertSame($this->randomString, $this->dataPrivateGet('mixed'));
    }

    /**
     * Test dataPrivateSetArray().
     */
    public function testDataPrivateSetArray(): void
    {
        $check = [
            'check1' => $this->randomString . '1',
            'check2' => $this->randomString . '2',
            'check3' => $this->randomString . '3',
            'check4' => $this->randomString . '4'
        ];

        $this->dataPrivateSetArray($check);

        $this->assertSame($check['check1'], $this->dataPrivateGet('check1'));
        $this->assertSame($check['check2'], $this->dataPrivateGet('check2'));
        $this->assertSame($check['check3'], $this->dataPrivateGet('check3'));
        $this->assertSame($check['check4'], $this->dataPrivateGet('check4'));
    }

    /**
     * Test dataPrivateGet().
     */
    public function testDataPrivateGet(): void
    {
        $this->assertSame($this->randomInt, $this->dataPrivateGet('int'));
        $this->assertSame($this->randomString, $this->dataPrivateGet('string'));
        $this->assertNull($this->dataPrivateGet('unknown'));
    }

    /**
     * Test dataPrivateSetString().
     */
    public function testDataPrivateSetString(): void
    {
        $this->assertSame('', $this->dataPrivateGetString('test'));
        $this->dataPrivateSetString('test', $this->randomString);
        $this->assertSame($this->randomString, $this->dataPrivateGetString('test'));
    }

    /**
     * Test dataPrivateGetStringNull().
     */
    public function testDataPrivateGetStringNull(): void
    {
        $this->assertSame((string)$this->randomInt, $this->dataPrivateGetStringNull('int'));
        $this->assertSame($this->randomString, $this->dataPrivateGetStringNull('string'));
        $this->assertNull($this->dataPrivateGetStringNull('unknown'));
    }

    /**
     * Test dataPrivateGetString().
     */
    public function testDataPrivateGetString(): void
    {
        $this->assertSame((string)$this->randomInt, $this->dataPrivateGetString('int'));
        $this->assertSame($this->randomString, $this->dataPrivateGetString('string'));
        $this->assertSame('', $this->dataPrivateGetString('unknown'));
    }

    /**
     * Test dataPrivateSetInt().
     */
    public function testDataPrivateSetInt(): void
    {
        $this->assertSame(0, $this->dataPrivateGetInt('test'));
        $this->dataPrivateSetInt('test', $this->randomInt);
        $this->assertSame($this->randomInt, $this->dataPrivateGetInt('test'));
    }

    /**
     * Test dataPrivateGetIntNull().
     */
    public function testDataPrivateGetIntNull(): void
    {
        $this->assertSame($this->randomInt, $this->dataPrivateGetIntNull('int'));
        $this->assertSame(intval($this->randomString), $this->dataPrivateGetIntNull('string'));
        $this->assertNull($this->dataPrivateGetIntNull('unknown'));
    }

    /**
     * Test dataPrivateGetInt().
     */
    public function testDataPrivateGetInt(): void
    {
        $this->assertSame($this->randomInt, $this->dataPrivateGetInt('int'));
        $this->assertSame(intval($this->randomString), $this->dataPrivateGetInt('string'));
        $this->assertSame(0, $this->dataPrivateGetInt('unknown'));
    }

    /**
     * Test dataPrivateSetBool() as numeric.
     */
    public function testDataPrivateSetBoolAsNumeric(): void
    {
        $this->dataPrivateSetBool('bool', 1);
        $this->assertTrue($this->dataPrivateGet('bool'));

        $this->dataPrivateSetBool('bool', 0);
        $this->assertFalse($this->dataPrivateGet('bool'));
    }

    /**
     * Test dataPrivateSetBool() as bool.
     */
    public function testDataPrivateSetBoolAsBool(): void
    {
        $this->dataPrivateSetBool('bool', true);
        $this->assertTrue($this->dataPrivateGet('bool'));

        $this->dataPrivateSetBool('bool', false);
        $this->assertFalse($this->dataPrivateGet('bool'));
    }

    /**
     * Test dataPrivateSetBool() as string numeric.
     */
    public function testDataPrivateSetBoolAsStringNumeric(): void
    {
        $this->dataPrivateSetBool('bool', '1');
        $this->assertTrue($this->dataPrivateGet('bool'));

        $this->dataPrivateSetBool('bool', '0');
        $this->assertFalse($this->dataPrivateGet('bool'));
    }

    /**
     * Test dataPrivateSetBool() as string bool.
     */
    public function testDataPrivateSetBoolAsStringBool(): void
    {
        $this->dataPrivateSetBool('bool', 'true');
        $this->assertTrue($this->dataPrivateGet('bool'));

        $this->dataPrivateSetBool('bool', 'false');
        $this->assertFalse($this->dataPrivateGet('bool'));
    }

    /**
     * Test dataPrivateSetBool() as string yes/no.
     */
    public function testDataPrivateSetBoolAsStringYesNo(): void
    {
        $this->dataPrivateSetBool('bool', 'yes');
        $this->assertTrue($this->dataPrivateGet('bool'));

        $this->dataPrivateSetBool('bool', 'no');
        $this->assertFalse($this->dataPrivateGet('bool'));
    }

    /**
     * Test dataPrivateSetBool() as string on/off.
     */
    public function testDataPrivateSetBoolAsStringOnOff(): void
    {
        $this->dataPrivateSetBool('bool', 'on');
        $this->assertTrue($this->dataPrivateGet('bool'));

        $this->dataPrivateSetBool('bool', 'off');
        $this->assertFalse($this->dataPrivateGet('bool'));
    }

    /**
     * Test dataPrivateGetBoolNull().
     */
    public function testDataPrivateGetBoolNull(): void
    {
        $this->assertNull($this->dataPrivateGetBoolNull('test'));

        $this->dataPrivateSet('test', true);
        $this->assertTrue($this->dataPrivateGetBoolNull('test'));

        $this->dataPrivateSet('test', false);
        $this->assertFalse($this->dataPrivateGetBoolNull('test'));
    }

    /**
     * Test dataPrivateGetBool() from numeric.
     */
    public function testDataPrivateGetBoolFromNumeric(): void
    {
        $this->dataPrivateSet('test', 1);
        $this->assertTrue($this->dataPrivateGetBool('test'));

        $this->dataPrivateSet('test', 0);
        $this->assertFalse($this->dataPrivateGetBool('test'));
    }

    /**
     * Test dataPrivateGetBool() from bool.
     */
    public function testDataPrivateGetBoolFromBool(): void
    {
        $this->dataPrivateSet('test', true);
        $this->assertTrue($this->dataPrivateGetBool('test'));

        $this->dataPrivateSet('test', false);
        $this->assertFalse($this->dataPrivateGetBool('test'));
    }

    /**
     * Test dataPrivateGetBool() from string numeric.
     */
    public function testDataPrivateGetBoolFromStringNumeric(): void
    {
        $this->dataPrivateSet('test', '1');
        $this->assertTrue($this->dataPrivateGetBool('test'));

        $this->dataPrivateSet('test', '0');
        $this->assertFalse($this->dataPrivateGetBool('test'));
    }

    /**
     * Test dataPrivateGetBool() from string bool.
     */
    public function testDataPrivateGetBoolFromStringBool(): void
    {
        $this->dataPrivateSet('test', 'true');
        $this->assertTrue($this->dataPrivateGetBool('test'));

        $this->dataPrivateSet('test', 'false');
        $this->assertFalse($this->dataPrivateGetBool('test'));
    }

    /**
     * Test dataPrivateGetBool() from string yes/no.
     */
    public function testDataPrivateGetBoolFromStringYesNo(): void
    {
        $this->dataPrivateSet('test', 'yes');
        $this->assertTrue($this->dataPrivateGetBool('test'));

        $this->dataPrivateSet('test', 'no');
        $this->assertFalse($this->dataPrivateGetBool('test'));
    }

    /**
     * Test dataPrivateGetBool() from on/off.
     */
    public function testDataPrivateGetBoolFromOnOff(): void
    {
        $this->dataPrivateSet('test', 'on');
        $this->assertTrue($this->dataPrivateGetBool('test'));

        $this->dataPrivateSet('test', 'off');
        $this->assertFalse($this->dataPrivateGetBool('test'));
    }

    /**
     * Test dataPrivateSetNull().
     */
    public function testDataPrivateSetNull(): void
    {
        $this->dataPrivateSet('test', 'something');
        $this->assertSame('something', $this->dataPrivateGet('test'));
        $this->dataPrivateSetNull('test');
        $this->assertNull($this->dataPrivateGet('test'));
    }

    /**
     * Test dataPrivateHas().
     */
    public function testDataPrivateHas(): void
    {
        $this->assertFalse($this->dataPrivateHas('unknown'));
        $this->assertTrue($this->dataPrivateHas('string'));
        $this->assertTrue($this->dataPrivateHas('int'));
    }

    /**
     * Test dataPrivateRemove().
     */
    public function testDataPrivateRemove(): void
    {
        $this->dataPrivateSet('test', 'something');
        $this->assertSame('something', $this->dataPrivateGet('test'));
        $this->dataPrivateRemove('test');
        $this->assertNull($this->dataPrivateGet('test'));
    }

    /**
     * Test dataPrivateAll().
     */
    public function testDataPrivateAll(): void
    {
        $data = $this->dataPrivateAll();
        $this->assertArrayHasKey('int', $data);
        $this->assertArrayHasKey('string', $data);
        $this->assertArrayNotHasKey('unknown', $data);
    }

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        // Set random int on data trait helper.
        $this->randomInt = random_int(1, 100000);
        $this->dataPrivateSet('int', $this->randomInt);

        // Set random string on data trait helper.
        $this->randomString = md5((string)$this->randomInt);
        $this->dataPrivateSet('string', $this->randomString);
    }
}