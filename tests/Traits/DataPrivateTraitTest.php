<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Traits;

use CoRex\Helpers\Obj;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Tests\CoRex\Helpers\Helpers\DataPrivate;

class DataPrivateTraitTest extends TestCase
{
    /** @var DataPrivate */
    private $dataPrivate;

    /** @var int */
    private $randomInt;

    /** @var string */
    private $randomString;

    public function testDataPrivateClear(): void
    {
        // Set data.
        $this->call('dataPrivateSet', ['mixed', 'something']);
        $this->call('dataPrivateSetInt', ['value', 7]);
        $this->call('dataPrivateSetBool', ['bool', true]);

        // Check is set.
        $this->assertNotEquals([], $this->call('dataPrivateAll'));

        // Clear.
        $this->call('dataPrivateClear');

        // Check is not set.
        $this->assertEquals([], $this->call('dataPrivateAll'));
    }

    public function testDataPrivateSet(): void
    {
        $this->call('dataPrivateSet', ['mixed', $this->randomString]);
        $this->assertSame($this->randomString, $this->call('dataPrivateGet', ['mixed']));
    }

    public function testDataPrivateSetArray(): void
    {
        $check = [
            'check1' => $this->randomString . '1',
            'check2' => $this->randomString . '2',
            'check3' => $this->randomString . '3',
            'check4' => $this->randomString . '4'
        ];

        $this->call('dataPrivateSetArray', [$check]);

        $this->assertSame($check['check1'], $this->call('dataPrivateGet', ['check1']));
        $this->assertSame($check['check2'], $this->call('dataPrivateGet', ['check2']));
        $this->assertSame($check['check3'], $this->call('dataPrivateGet', ['check3']));
        $this->assertSame($check['check4'], $this->call('dataPrivateGet', ['check4']));
    }

    public function testDataPrivateGet(): void
    {
        $this->assertSame($this->randomInt, $this->call('dataPrivateGet', ['int']));
        $this->assertSame($this->randomString, $this->call('dataPrivateGet', ['string']));
        $this->assertNull($this->call('dataPrivateGet', ['unknown']));
    }

    public function testDataPrivateSetString(): void
    {
        $this->assertSame('', $this->call('dataPrivateGetString', ['test']));
        $this->call('dataPrivateSetString', ['test', $this->randomString]);
        $this->assertSame($this->randomString, $this->call('dataPrivateGetString', ['test']));
    }

    public function testDataPrivateGetStringNull(): void
    {
        $this->assertSame((string)$this->randomInt, $this->call('dataPrivateGetStringNull', ['int']));
        $this->assertSame($this->randomString, $this->call('dataPrivateGetStringNull', ['string']));
        $this->assertNull($this->call('dataPrivateGetStringNull', ['unknown']));
    }

    public function testDataPrivateGetString(): void
    {
        $this->assertSame((string)$this->randomInt, $this->call('dataPrivateGetString', ['int']));
        $this->assertSame($this->randomString, $this->call('dataPrivateGetString', ['string']));
        $this->assertSame('', $this->call('dataPrivateGetString', ['unknown']));
    }

    public function testDataPrivateSetInt(): void
    {
        $this->assertSame(0, $this->call('dataPrivateGetInt', ['test']));
        $this->call('dataPrivateSetInt', ['test', $this->randomInt]);
        $this->assertSame($this->randomInt, $this->call('dataPrivateGetInt', ['test']));
    }

    public function testDataPrivateGetIntNull(): void
    {
        $this->assertSame($this->randomInt, $this->call('dataPrivateGetIntNull', ['int']));
        $this->assertSame(intval($this->randomString), $this->call('dataPrivateGetIntNull', ['string']));
        $this->assertNull($this->call('dataPrivateGetIntNull', ['unknown']));
    }

    public function testDataPrivateGetInt(): void
    {
        $this->assertSame($this->randomInt, $this->call('dataPrivateGetInt', ['int']));
        $this->assertSame(intval($this->randomString), $this->call('dataPrivateGetInt', ['string']));
        $this->assertSame(0, $this->call('dataPrivateGetInt', ['unknown']));
    }

    public function testDataPrivateSetBoolAsNumeric(): void
    {
        $this->call('dataPrivateSetBool', ['bool', 1]);
        $this->assertTrue($this->call('dataPrivateGet', ['bool']));

        $this->call('dataPrivateSetBool', ['bool', 0]);
        $this->assertFalse($this->call('dataPrivateGet', ['bool']));
    }

    public function testDataPrivateSetBoolAsBool(): void
    {
        $this->call('dataPrivateSetBool', ['bool', true]);
        $this->assertTrue($this->call('dataPrivateGet', ['bool']));

        $this->call('dataPrivateSetBool', ['bool', false]);
        $this->assertFalse($this->call('dataPrivateGet', ['bool']));
    }

    public function testDataPrivateSetBoolAsStringNumeric(): void
    {
        $this->call('dataPrivateSetBool', ['bool', '1']);
        $this->assertTrue($this->call('dataPrivateGet', ['bool']));

        $this->call('dataPrivateSetBool', ['bool', '0']);
        $this->assertFalse($this->call('dataPrivateGet', ['bool']));
    }

    public function testDataPrivateSetBoolAsStringBool(): void
    {
        $this->call('dataPrivateSetBool', ['bool', 'true']);
        $this->assertTrue($this->call('dataPrivateGet', ['bool']));

        $this->call('dataPrivateSetBool', ['bool', 'false']);
        $this->assertFalse($this->call('dataPrivateGet', ['bool']));
    }

    public function testDataPrivateSetBoolAsStringYesNo(): void
    {
        $this->call('dataPrivateSetBool', ['bool', 'yes']);
        $this->assertTrue($this->call('dataPrivateGet', ['bool']));

        $this->call('dataPrivateSetBool', ['bool', 'no']);
        $this->assertFalse($this->call('dataPrivateGet', ['bool']));
    }

    public function testDataPrivateSetBoolAsStringOnOff(): void
    {
        $this->call('dataPrivateSetBool', ['bool', 'on']);
        $this->assertTrue($this->call('dataPrivateGet', ['bool']));

        $this->call('dataPrivateSetBool', ['bool', 'off']);
        $this->assertFalse($this->call('dataPrivateGet', ['bool']));
    }

    public function testDataPrivateGetBoolNull(): void
    {
        $this->assertNull($this->call('dataPrivateGetBoolNull', ['test']));

        $this->call('dataPrivateSet', ['test', true]);
        $this->assertTrue($this->call('dataPrivateGetBoolNull', ['test']));

        $this->call('dataPrivateSet', ['test', false]);
        $this->assertFalse($this->call('dataPrivateGetBoolNull', ['test']));
    }

    public function testDataPrivateGetBoolFromNumeric(): void
    {
        $this->call('dataPrivateSet', ['test', 1]);
        $this->assertTrue($this->call('dataPrivateGetBool', ['test']));

        $this->call('dataPrivateSet', ['test', 0]);
        $this->assertFalse($this->call('dataPrivateGetBool', ['test']));
    }

    public function testDataPrivateGetBoolFromBool(): void
    {
        $this->call('dataPrivateSet', ['test', true]);
        $this->assertTrue($this->call('dataPrivateGetBool', ['test']));

        $this->call('dataPrivateSet', ['test', false]);
        $this->assertFalse($this->call('dataPrivateGetBool', ['test']));
    }

    public function testDataPrivateGetBoolFromStringNumeric(): void
    {
        $this->call('dataPrivateSet', ['test', '1']);
        $this->assertTrue($this->call('dataPrivateGetBool', ['test']));

        $this->call('dataPrivateSet', ['test', '0']);
        $this->assertFalse($this->call('dataPrivateGetBool', ['test']));
    }

    public function testDataPrivateGetBoolFromStringBool(): void
    {
        $this->call('dataPrivateSet', ['test', 'true']);
        $this->assertTrue($this->call('dataPrivateGetBool', ['test']));

        $this->call('dataPrivateSet', ['test', 'false']);
        $this->assertFalse($this->call('dataPrivateGetBool', ['test']));
    }

    public function testDataPrivateGetBoolFromStringYesNo(): void
    {
        $this->call('dataPrivateSet', ['test', 'yes']);
        $this->assertTrue($this->call('dataPrivateGetBool', ['test']));

        $this->call('dataPrivateSet', ['test', 'no']);
        $this->assertFalse($this->call('dataPrivateGetBool', ['test']));
    }

    public function testDataPrivateGetBoolFromOnOff(): void
    {
        $this->call('dataPrivateSet', ['test', 'on']);
        $this->assertTrue($this->call('dataPrivateGetBool', ['test']));

        $this->call('dataPrivateSet', ['test', 'off']);
        $this->assertFalse($this->call('dataPrivateGetBool', ['test']));
    }

    public function testDataPrivateSetNull(): void
    {
        $this->call('dataPrivateSet', ['test', 'something']);
        $this->assertSame('something', $this->call('dataPrivateGet', ['test']));
        $this->call('dataPrivateSetNull', ['test', null]);
        $this->assertNull($this->call('dataPrivateGet', ['test']));
    }

    public function testDataPrivateHas(): void
    {
        $this->assertFalse($this->call('dataPrivateHas', ['unknown']));
        $this->assertTrue($this->call('dataPrivateHas', ['string']));
        $this->assertTrue($this->call('dataPrivateHas', ['int']));
    }

    public function testDataPrivateRemove(): void
    {
        $this->call('dataPrivateSet', ['test', 'something']);
        $this->assertEquals('something', $this->call('dataPrivateGet', ['test']));
        $this->call('dataPrivateRemove', ['test']);
        $this->assertNull($this->call('dataPrivateGet', ['test']));
    }

    public function testDataPrivateAll(): void
    {
        $data = $this->call('dataPrivateAll');
        $this->assertArrayHasKey('int', $data);
        $this->assertArrayHasKey('string', $data);
        $this->assertArrayNotHasKey('unknown', $data);
    }

    /**
     * Call method.
     *
     * @param string $method
     * @param mixed[] $arguments
     * @param object|null $dataPrivate
     * @return mixed
     */
    private function call(string $method, array $arguments = [], ?object $dataPrivate = null)
    {
        if ($dataPrivate === null) {
            $dataPrivate = $this->dataPrivate;
        }

        try {
            $value = Obj::callMethod($method, $dataPrivate, $arguments);
        } catch (ReflectionException $e) {
            $value = null;
        }

        return $value;
    }

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->dataPrivate = new DataPrivate();

        // Set random int on data trait helper.
        $this->randomInt = mt_rand(1, 100000);
        $this->call('dataPrivateSet', ['int', $this->randomInt]);

        // Set random string on data trait helper.
        $this->randomString = md5((string)$this->randomInt);
        $this->call('dataPrivateSet', ['string', $this->randomString]);
    }
}