<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers;

use CoRex\Helpers\Bag;
use CoRex\Helpers\Obj;
use Exception;
use PHPUnit\Framework\TestCase;

class BagTest extends TestCase
{
    /** @var string[] */
    private $data = [
        'actor' => [
            'firstname' => 'Roger',
            'lastname' => 'Moore'
        ]
    ];

    /**
     * Test constructor no data.
     *
     * @throws Exception
     */
    public function testConstructorNull(): void
    {
        $container = new Bag(null);
        $this->assertEquals([], Obj::getProperty('properties', $container));
    }

    /**
     * Test constructor no data.
     */
    public function testConstructorNoData(): void
    {
        $container = new Bag();
        $this->assertEquals([], $container->all());
    }

    /**
     * Test constructor with data.
     */
    public function testConstructorWithData(): void
    {
        $container = new Bag($this->data);
        $this->assertEquals($this->data, $container->all());
    }

    /**
     * Test clear no data.
     */
    public function testClearNoData(): void
    {
        $container = new Bag();
        $this->assertEquals([], $container->all());
    }

    /**
     * Test clear null.
     */
    public function testClearNull(): void
    {
        $container = new Bag();
        $container->clear(null);
        $this->assertEquals([], $container->all());
    }

    /**
     * Test clear with data.
     */
    public function testClearWithData(): void
    {
        $container = new Bag();
        $container->clear($this->data);
        $this->assertEquals($this->data, $container->all());
    }

    /**
     * Test has no data.
     *
     * @throws Exception
     */
    public function testHasNoData(): void
    {
        $container = new Bag();
        $this->assertFalse($container->has('actor.firstname'));
    }

    /**
     * Test has with data.
     *
     * @throws Exception
     */
    public function testHasWithData(): void
    {
        $container = new Bag();
        $container->clear($this->data);
        $this->assertTrue($container->has('actor.firstname'));
    }

    /**
     * Test set.
     *
     * @throws Exception
     */
    public function testSet(): void
    {
        $container = new Bag($this->data);

        // Check standard data.
        $this->assertEquals($this->data['actor']['firstname'], $container->get('actor.firstname'));
        $this->assertEquals($this->data['actor']['lastname'], $container->get('actor.lastname'));

        // Swap data.
        $container->set('actor.firstname', $this->data['actor']['lastname']);
        $container->set('actor.lastname', $this->data['actor']['firstname']);

        // Check swapped data.
        $this->assertEquals($this->data['actor']['lastname'], $container->get('actor.firstname'));
        $this->assertEquals($this->data['actor']['firstname'], $container->get('actor.lastname'));
    }

    /**
     * Test set array.
     *
     * @throws Exception
     */
    public function testSetArray(): void
    {
        $container = new Bag();
        $container->setArray($this->data);

        // Check standard data.
        $this->assertEquals($this->data['actor']['firstname'], $container->get('actor.firstname'));
        $this->assertEquals($this->data['actor']['lastname'], $container->get('actor.lastname'));
    }

    /**
     * Test get.
     *
     * @throws Exception
     */
    public function testGet(): void
    {
        $container = new Bag($this->data);

        // Check standard data.
        $this->assertEquals($this->data['actor']['firstname'], $container->get('actor.firstname'));
        $this->assertEquals($this->data['actor']['lastname'], $container->get('actor.lastname'));
    }

    /**
     * Test remove.
     *
     * @throws Exception
     */
    public function testRemove(): void
    {
        $container = new Bag($this->data);

        // Check standard data.
        $this->assertEquals($this->data['actor']['firstname'], $container->get('actor.firstname'));
        $this->assertEquals($this->data['actor']['lastname'], $container->get('actor.lastname'));

        // Delete data.
        $container->remove('actor.firstname');

        // Check standard data.
        $this->assertNull($container->get('actor.firstname'));
        $this->assertEquals($this->data['actor']['lastname'], $container->get('actor.lastname'));
    }

    /**
     * Test keys.
     */
    public function testKeys(): void
    {
        $container = new Bag($this->data);
        $all = $container->all();
        $this->assertEquals(array_keys($all), $container->keys());
    }

    /**
     * Test all.
     */
    public function testAll(): void
    {
        $container = new Bag($this->data);
        $this->assertEquals($this->data, $container->all());
    }
}
