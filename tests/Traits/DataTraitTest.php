<?php

namespace Tests\CoRex\Helpers\Traits;

use PHPUnit\Framework\TestCase;
use Tests\CoRex\Helpers\Helpers\Data;

class DataTraitTest extends TestCase
{
    private $randomString;
    private $randomInt;
    private $randomBoolean;

    /**
     * Test clear.
     */
    public function testClear()
    {
        $data = $this->data()
            ->set('mixed', 'something')
            ->setInt('value', 7)
            ->setBool('bool', true);
        $this->assertNotEquals([], $data->all());
        $data->clear();
        $this->assertEquals([], $data->all());
    }

    /**
     * Test setArray no merge.
     */
    public function testSetArrayNoMerge()
    {
        $md5 = md5(mt_rand(1, 100000));
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
        $this->assertEquals($check1, $data->get('check1'));
        $this->assertEquals($check2, $data->get('check2'));
        $this->assertEquals($check3, $data->get('check3'));
        $this->assertEquals($check4, $data->get('check4'));
    }

    /**
     * Test setArray merge.
     */
    public function testSetArrayMerge()
    {
        $md5 = md5(mt_rand(1, 100000));
        $check1 = $md5 . '1';
        $check2 = $md5 . '2';
        $check3 = $md5 . '3';
        $check4 = $md5 . '4';

        $data = $this->data()
            ->set('check1', $check1)
            ->set('check2', $check2);
        $this->assertEquals($check1, $data->get('check1'));
        $this->assertEquals($check2, $data->get('check2'));
        $this->assertNull($data->get('check3'));
        $this->assertNull($data->get('check4'));

        $data->setArray([
            'check3' => $check3,
            'check4' => $check4
        ], true);

        $this->assertEquals($check1, $data->get('check1'));
        $this->assertEquals($check2, $data->get('check2'));
        $this->assertEquals($check3, $data->get('check3'));
        $this->assertEquals($check4, $data->get('check4'));
    }

    /**
     * Test has.
     */
    public function testHas()
    {
        $data = $this->data();
        $this->assertFalse($data->has('check'));
        $data->setNull('check');
        $this->assertTrue($data->has('check'));
    }

    /**
     * Test get/set.
     */
    public function testGetSet()
    {
        $check = md5(mt_rand(1, 100000));
        $data = $this->data()->set('mixed', $check);
        $this->assertEquals($check, $data->get('mixed'));
    }

    /**
     * Test getInt.
     */
    public function testGetInt()
    {
        $value = mt_rand(1, 100000);
        $data = $this->data()->set('int', $value);
        $this->assertEquals($value, $data->getInt('int'));
    }

    /**
     * Test setInt.
     */
    public function testSetInt()
    {
        $value = mt_rand(1, 100000);
        $data = $this->data()->setInt('int', $value);
        $this->assertEquals(['int' => $value], $data->all());
    }

    /**
     * Test getBool from numeric.
     */
    public function testGetBoolFromNumeric()
    {
        $data = $this->data()->set('bool', 1);
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 0);
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from boolean.
     */
    public function testGetBoolFromBoolean()
    {
        $data = $this->data()->set('bool', true);
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', false);
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string numeric.
     */
    public function testGetBoolFromStringNumeric()
    {
        $data = $this->data()->set('bool', '1');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', '0');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string boolean.
     */
    public function testGetBoolFromStringBoolean()
    {
        $data = $this->data()->set('bool', 'true');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 'false');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string yes/no.
     */
    public function testGetBoolFromStringYesNo()
    {
        $data = $this->data()->set('bool', 'yes');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 'no');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test getBool from string on/off.
     */
    public function testGetBoolFromStringOnOff()
    {
        $data = $this->data()->set('bool', 'on');
        $this->assertTrue($data->getBool('bool'));

        $data = $this->data()->set('bool', 'off');
        $this->assertFalse($data->getBool('bool'));
    }

    /**
     * Test setBool as numeric.
     */
    public function testSetBoolAsNumeric()
    {
        $data = $this->data()->setBool('bool', 1);
        $this->assertEquals(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 0);
        $this->assertEquals(['bool' => false], $data->all());
    }

    /**
     * Test setBool as bool.
     */
    public function testSetBoolAsBool()
    {
        $data = $this->data()->setBool('bool', true);
        $this->assertEquals(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', false);
        $this->assertEquals(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string numeric.
     */
    public function testSetBoolAsStringNumeric()
    {
        $data = $this->data()->setBool('bool', '1');
        $this->assertEquals(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', '0');
        $this->assertEquals(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string bool.
     */
    public function testSetBoolAsStringBool()
    {
        $data = $this->data()->setBool('bool', 'true');
        $this->assertEquals(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 'false');
        $this->assertEquals(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string yes/no.
     */
    public function testSetBoolAsStringYesNo()
    {
        $data = $this->data()->setBool('bool', 'yes');
        $this->assertEquals(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 'no');
        $this->assertEquals(['bool' => false], $data->all());
    }

    /**
     * Test setBool as string on/off.
     */
    public function testSetBoolAsStringOnOff()
    {
        $data = $this->data()->setBool('bool', 'on');
        $this->assertEquals(['bool' => true], $data->all());

        $data = $this->data()->setBool('bool', 'off');
        $this->assertEquals(['bool' => false], $data->all());
    }

    /**
     * Test setNull.
     */
    public function testSetNull()
    {
        $data = $this->data();
        $data->set('test', 'something');
        $this->assertEquals('something', $data->get('test'));
        $data->setNull('test');
        $this->assertEquals(['test' => null], $data->all());
    }

    /**
     * Test remove.
     */
    public function testRemove()
    {
        $data = $this->data();
        $data->set('test', 'something');
        $this->assertEquals('something', $data->get('test'));
        $data->remove('test');
        $this->assertEquals([], $data->all());
    }

    /**
     * Test all.
     */
    public function testAll()
    {
        $data = $this->data();
        $this->assertEquals([], $data->all());
        $data->set('mixed', 'something');
        $data->setInt('value', 7);
        $data->setBool('bool', true);
        $this->assertNotEquals([], $data->all());
    }

    /**
     * Data.
     *
     * @return Data
     */
    public function data()
    {
        return new Data();
    }

    /**
     * Setup.
     */
    protected function setUp()
    {
        parent::setUp();

        // Set random values.
        $this->randomString = md5(mt_rand(1, 100000));
        $this->randomInt = mt_rand(1, 100000);
        $this->randomBoolean = mt_rand(0, 1) == 1;
    }
}