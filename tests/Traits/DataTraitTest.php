<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Traits;

use CoRex\Helpers\Traits\DataTrait;
use PHPUnit\Framework\TestCase;
use Tests\CoRex\Helpers\Helpers\Data;

class DataTraitTest extends TestCase
{
    /**
     * Test clear.
     */
    public function testClear(): void
    {
        $data = $this->data()
            ->set('mixed', 'something')
            ->setInt('value', 7)
            ->setBool('bool', true);
        $this->assertNotSame([], $data->all());
        $data->clear();
        $this->assertSame([], $data->all());
    }

    /**
     * Test setArray no merge.
     */
    public function testSetArrayNoMerge(): void
    {
        $md5 = md5((string)random_int(1, 100000));
        $check1 = $md5 . '1';
        $check2 = $md5 . '2';
        $check3 = $md5 . '3';
        $check4 = $md5 . '4';
        $check = [
            'check1' => $check1,
            'check2' => $check2,
            'check3' => $check3,
            'check4' => $check4
        ];
        $data = $this->data()->setArray($check);
        $this->assertSame($check1, $data->get('check1'));
        $this->assertSame($check2, $data->get('check2'));
        $this->assertSame($check3, $data->get('check3'));
        $this->assertSame($check4, $data->get('check4'));
    }

    /**
     * Test setArray merge.
     */
    public function testSetArrayMerge(): void
    {
        $md5 = md5((string)random_int(1, 100000));
        $check1 = $md5 . '1';
        $check2 = $md5 . '2';
        $check3 = $md5 . '3';
        $check4 = $md5 . '4';

        $data = $this->data()
            ->set('check1', $check1)
            ->set('check2', $check2);
        $this->assertSame($check1, $data->get('check1'));
        $this->assertSame($check2, $data->get('check2'));
        $this->assertNull($data->get('check3'));
        $this->assertNull($data->get('check4'));

        $data->setArray([
            'check3' => $check3,
            'check4' => $check4
        ], true);

        $this->assertSame($check1, $data->get('check1'));
        $this->assertSame($check2, $data->get('check2'));
        $this->assertSame($check3, $data->get('check3'));
        $this->assertSame($check4, $data->get('check4'));
    }

    /**
     * Test has.
     */
    public function testHas(): void
    {
        $data = $this->data();
        $this->assertFalse($data->has('check'));
        $data->setNull('check');
        $this->assertTrue($data->has('check'));
    }

    /**
     * Test get/set.
     */
    public function testGetSet(): void
    {
        $check = md5((string)random_int(1, 100000));
        $data = $this->data()->set('mixed', $check);
        $this->assertSame($check, $data->get('mixed'));
    }

    /**
     * Test getInt.
     */
    public function testGetInt(): void
    {
        $value = random_int(1, 100000);
        $data = $this->data()->set('int', $value);
        $this->assertSame($value, $data->getInt('int'));
    }

    /**
     * Test setInt.
     */
    public function testSetInt(): void
    {
        $value = random_int(1, 100000);
        $data = $this->data()->setInt('int', $value);
        $this->assertSame(['int' => $value], $data->all());
    }

    /**
     * Test getBool from numeric.
     */
    public function testGetBoolFromNumeric(): void
    {
        $data = $this->data()->set('bool', 1);
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 0);
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from boolean.
     */
    public function testGetBoolFromBoolean(): void
    {
        $data = $this->data()->set('bool', true);
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', false);
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string numeric.
     */
    public function testGetBoolFromStringNumeric(): void
    {
        $data = $this->data()->set('bool', '1');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', '0');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string boolean.
     */
    public function testGetBoolFromStringBoolean(): void
    {
        $data = $this->data()->set('bool', 'true');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 'false');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string yes/no.
     */
    public function testGetBoolFromStringYesNo(): void
    {
        $data = $this->data()->set('bool', 'yes');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 'no');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string on/off.
     */
    public function testGetBoolFromStringOnOff(): void
    {
        $data = $this->data()->set('bool', 'on');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 'off');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test setBool as numeric.
     */
    public function testSetBoolAsNumeric(): void
    {
        $data = $this->data()->setBool('bool', 1);
        $this->assertSame(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 0);
        $this->assertSame(['bool' => false], $data->all());
    }

    /**
     * Test setBool as bool.
     */
    public function testSetBoolAsBool(): void
    {
        $data = $this->data()->setBool('bool', true);
        $this->assertSame(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', false);
        $this->assertSame(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string numeric.
     */
    public function testSetBoolAsStringNumeric(): void
    {
        $data = $this->data()->setBool('bool', '1');
        $this->assertSame(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', '0');
        $this->assertSame(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string bool.
     */
    public function testSetBoolAsStringBool(): void
    {
        $data = $this->data()->setBool('bool', 'true');
        $this->assertSame(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 'false');
        $this->assertSame(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string yes/no.
     */
    public function testSetBoolAsStringYesNo(): void
    {
        $data = $this->data()->setBool('bool', 'yes');
        $this->assertSame(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 'no');
        $this->assertSame(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string on/off.
     */
    public function testSetBoolAsStringOnOff(): void
    {
        $data = $this->data()->setBool('bool', 'on');
        $this->assertSame(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 'off');
        $this->assertSame(['bool' => false], $data->all());
    }

    /**
     * Test setNull.
     */
    public function testSetNull(): void
    {
        $data = $this->data();
        $data->set('test', 'something');
        $this->assertSame('something', $data->get('test'));
        $data->setNull('test');
        $this->assertSame(['test' => null], $data->all());
    }

    /**
     * Test remove.
     */
    public function testRemove(): void
    {
        $data = $this->data();
        $data->set('test', 'something');
        $this->assertSame('something', $data->get('test'));
        $data->remove('test');
        $this->assertSame([], $data->all());
    }

    /**
     * Test all.
     */
    public function testAll(): void
    {
        $data = $this->data();
        $this->assertSame([], $data->all());
        $data->set('mixed', 'something');
        $data->setInt('value', 7);
        $data->setBool('bool', true);
        $this->assertNotSame([], $data->all());
    }

    /**
     * Data.
     *
     * @return Data|DataTrait
     */
    public function data(): Data
    {
        return new Data();
    }
}