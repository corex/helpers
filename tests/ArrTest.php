<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers;

use CoRex\Helpers\Arr;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;

class ArrTest extends TestCase
{
    /** @var string[] */
    private $actor1 = ['firstname' => 'Sean', 'lastname' => 'Connery'];

    /** @var string[] */
    private $actor2 = ['firstname' => 'Roger', 'lastname' => 'Moore'];

    /** @var string[] */
    private $actor3 = ['firstname' => 'Timothy', 'lastname' => 'Dalton'];

    /** @var string[] */
    private $actor4 = ['firstname' => 'Pierce', 'lastname' => 'Brosnan'];

    /** @var string[] */
    private $actor5 = ['firstname' => 'Daniel', 'lastname' => 'Craig'];

    /**
     * Test get.
     */
    public function testGet(): void
    {
        $data = ['actor' => $this->actor1];
        $this->assertSame($this->actor1['firstname'], Arr::get($data, 'actor.firstname'));
        $this->assertSame($this->actor1['lastname'], Arr::get($data, 'actor.lastname'));
        $this->assertSame('test', Arr::get($data, 'actor.test', 'test'));
        $this->assertNull(Arr::get($data, 'actor.test'));
    }

    /**
     * Test get empty key.
     */
    public function testGetEmptyKey(): void
    {
        $data = ['actor' => $this->actor1];
        $this->assertSame($this->actor1['firstname'], Arr::get($data, 'actor.firstname'));
        $this->assertSame($this->actor1['lastname'], Arr::get($data, 'actor.lastname'));
        $this->assertSame('test', Arr::get($data, 'actor.test', 'test'));
        $this->assertSame($data, Arr::get($data, ''));
    }

    /**
     * Test set.
     */
    public function testSet(): void
    {
        $data = [];
        $this->assertNull(Arr::get($data, 'actor.test1.test2'));
        Arr::set($data, 'actor.test1.test2', 'testing', true);
        $this->assertSame('testing', Arr::get($data, 'actor.test1.test2'));
    }

    /**
     * Test get first.
     */
    public function testGetFirst(): void
    {
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $this->assertSame($this->actor1, Arr::first($data));
        $this->assertSame($this->actor1['firstname'], Arr::first($data, 'firstname'));
    }

    /**
     * Test get first null.
     */
    public function testGetFirstNull(): void
    {
        $this->assertNull(Arr::first([]));
    }

    /**
     * Test get last.
     */
    public function testGetLast(): void
    {
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $this->assertSame($this->actor5, Arr::last($data));
        $this->assertSame($this->actor5['firstname'], Arr::last($data, 'firstname'));
    }

    /**
     * Test get last null.
     */
    public function testGetLastNull(): void
    {
        $this->assertNull(Arr::last([]));
    }

    /**
     * Test has.
     *
     * @throws Exception
     */
    public function testHas(): void
    {
        $data = [
            'this' => [
                'is' => [
                    'a' => [
                        'test' => md5((string)random_int(1, 100000))
                    ]
                ]
            ]
        ];
        $this->assertTrue(Arr::has($data, 'this.is.a.test'));
        $this->assertFalse(Arr::has($data, 'unknown'));
    }

    /**
     * Test remove.
     *
     * @throws Exception
     */
    public function testRemove(): void
    {
        $data = [
            'this' => [
                'is' => [
                    'a' => [
                        'test' => md5((string)random_int(1, 100000))
                    ]
                ]
            ]
        ];
        $this->assertTrue(Arr::has($data, 'this.is.a.test'));
        $data = Arr::remove($data, 'this.is.a.test');
        $this->assertFalse(Arr::has($data, 'this.is.a.test'));
    }

    /**
     * Test remove first.
     */
    public function testRemoveFirst(): void
    {
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $data = Arr::removeFirst($data);
        $this->assertSame($this->actor2, Arr::first($data));
    }

    /**
     * Test remove last.
     */
    public function testRemoveLast(): void
    {
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $data = Arr::removeLast($data);
        $this->assertSame($this->actor4, Arr::last($data));
    }

    /**
     * Test is list.
     */
    public function testIsList(): void
    {
        $data = [
            'actor1' => $this->actor1,
            'actor2' => $this->actor2,
            'actor3' => $this->actor3,
            'actor4' => $this->actor4,
            'actor5' => $this->actor5
        ];
        $this->assertFalse(Arr::isList($data));
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $this->assertTrue(Arr::isList($data));
    }

    /**
     * Test is string in list.
     */
    public function testIsStringInList(): void
    {
        $data = [4345, 435, 234, 43, 435, 345, 2354];
        $this->assertFalse(Arr::isStringInList($data));
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $this->assertTrue(Arr::isStringInList($data, 'firstname'));
    }

    /**
     * Test is string in list false.
     */
    public function testIsStringInListFalse(): void
    {
        $this->assertFalse(Arr::isStringInList([]));
    }

    /**
     * Test index of simple.
     */
    public function testIndexOfSimple(): void
    {
        // Test simple array.
        $data = ['test1', 'test2', 'test3'];
        $this->assertSame(1, Arr::indexOf($data, 'test2'));
    }

    /**
     * Test index of simple associative.
     */
    public function testIndexOfSimpleAssociative(): void
    {
        // Test simple array with associative item.
        $data = [$this->actor1, $this->actor2, $this->actor3, $this->actor4, $this->actor5];
        $this->assertSame(1, Arr::indexOf($data, $this->actor2['firstname'], 'firstname'));
    }

    /**
     * Test index of associative.
     */
    public function testIndexOfAssociative(): void
    {
        // Test associative array.
        $data = ['test1' => 'test1', 'test2' => 'test2', 'test3' => 'test3'];
        $this->assertSame('test2', Arr::indexOf($data, 'test2'));
    }

    /**
     * Test index of object array.
     */
    public function testIndexOfObjectArray(): void
    {
        // Test object array.
        $data = [];

        $actor1 = new stdClass();
        $actor1->value = 'test1';
        $data[] = $actor1;

        $actor2 = new stdClass();
        $actor2->value = 'test2';
        $data[] = $actor2;

        $this->assertSame(1, Arr::indexOf($data, 'test2', 'value'));
    }

    /**
     * Test index of associative associative.
     */
    public function testIndexOfAssociativeAssociative(): void
    {
        // Test associative array with associative item.
        $data = [
            'actor1' => $this->actor1,
            'actor2' => $this->actor2,
            'actor3' => $this->actor3,
            'actor4' => $this->actor4,
            'actor5' => $this->actor5
        ];
        $this->assertSame('actor2', Arr::indexOf($data, $this->actor2['firstname'], 'firstname'));
    }

    /**
     * Test index of empty array.
     */
    public function testIndexOfEmptyArray(): void
    {
        $this->assertSame(-1, Arr::indexOf([], 'not.existing'));
    }

    /**
     * Test keys exist.
     */
    public function testKeysExist(): void
    {
        $data = ['actor1' => 'test', 'actor2' => 'test', 'actor3' => 'test', 'actor4' => 'test'];
        $this->assertFalse(Arr::keysExist($data, ['unknown', 'actor3']));
        $this->assertTrue(Arr::keysExist($data, ['actor1', 'actor3']));
    }

    /**
     * Test keys.
     */
    public function testKeys(): void
    {
        $data = ['actor1' => 'test', 'actor2' => 'test', 'actor3' => 'test', 'actor4' => 'test'];
        $this->assertSame(array_keys($data), Arr::keys($data));
    }

    /**
     * Test is associative.
     */
    public function testIsAssociative(): void
    {
        $data = ['test1', 'test2', 'test3'];
        $this->assertFalse(Arr::isAssociative($data));
        $data = ['actor1' => 'test', 'actor2' => 'test', 'actor3' => 'test', 'actor4' => 'test'];
        $this->assertTrue(Arr::isAssociative($data));
    }

    /**
     * Test values.
     */
    public function testValues(): void
    {
        $check1 = md5((string)random_int(1, 100000));
        $check2 = md5((string)random_int(1, 100000));
        $data = [];
        $data[4] = $check1;
        $data[7] = $check2;
        $this->assertSame([$check1, $check2], Arr::values($data));
    }

    /**
     * Test pluck not array.
     */
    public function testPluckNotArray(): void
    {
        $this->assertSame([], Arr::pluck('not.array', 'dummy.key'));
    }

    /**
     * Test pluck simple associative.
     */
    public function testPluckSimpleAssociative(): void
    {
        // Test simple array with associative item.
        $checkData = [$this->actor1['firstname'], $this->actor2['firstname']];
        $data = [$this->actor1, $this->actor2];
        $this->assertSame($checkData, Arr::pluck($data, 'firstname'));
    }

    /**
     * Test pluck simple associative.
     */
    public function testPluckAssociative(): void
    {
        // Test associative array.
        $data = ['test1' => 'test1', 'test2' => 'test2', 'test3' => 'test3'];
        $this->assertSame([null, null, null], Arr::pluck($data, 'test2'));
    }

    /**
     * Test pluck simple object.
     */
    public function testPluckObject(): void
    {
        // Test object array.
        $data = [];

        $actor1 = new stdClass();
        $actor1->value = 'test1';
        $data[] = $actor1;

        $actor2 = new stdClass();
        $actor2->value = 'test2';
        $data[] = $actor2;

        $this->assertSame(['test1', 'test2'], Arr::pluck($data, 'value'));
    }

    /**
     * Test pluck.
     */
    public function testPluckDeepArray(): void
    {
        // Test associative array.
        $data = ['test1' => ['test2' => ['test2' => ['test3' => 'test3']]]];
        $this->assertSame(['test3'], Arr::pluck($data, 'test1.test2.test3'));
    }

    /**
     * Test get line match.
     */
    public function testLineMatch(): void
    {
        $lines = [
            '         use CoRex\Database\Command\CommandBase;                   ',
            '                          use CoRex\Database\Interfaces\ConnectorInterface;                ',
            'use CoRex\Support\System\Directory;               ',
            '            use CoRex\Support\System\Template;       '
        ];
        $linesMatch = [
            'CoRex\Database\Command\CommandBase',
            'CoRex\Database\Interfaces\ConnectorInterface',
            'CoRex\Support\System\Directory',
            'CoRex\Support\System\Template'
        ];
        $this->assertSame($linesMatch, Arr::lineMatch($lines, 'use ', ';', true, true));
    }

    /**
     * Test get line match isHit.
     */
    public function testLineMatchIsHit(): void
    {
        $lines = [
            '         use CoRex\Database\Command\CommandBase;                   ',
            '                          use CoRex\Database\Interfaces\ConnectorInterface;                ',
            'use CoRex\Support\System\Directory;               ',
            '            use CoRex\Support\System\Template;       '
        ];
        $this->assertSame([], Arr::lineMatch($lines, '-', '-', true, true));
    }

    /**
     * Test toArray by string.
     */
    public function testToArrayByString(): void
    {
        $this->assertSame(['a', 'b', 'c', 'd'], Arr::toArray('a.b.c.d'));
    }

    /**
     * Test toArray by empty string.
     */
    public function testToArrayByEmptyString(): void
    {
        $this->assertSame([], Arr::toArray(''));
    }

    /**
     * Test toArray by array.
     */
    public function testToArrayByArray(): void
    {
        $this->assertSame(['a', 'b', 'c', 'd'], Arr::toArray(['a', 'b', 'c', 'd']));
    }

    /**
     * Test toArray by empty array.
     */
    public function testToArrayByEmptyArray(): void
    {
        $this->assertSame([], Arr::toArray([]));
    }

    /**
     * Test toArray by other type.
     */
    public function testToArrayByOtherType(): void
    {
        $this->assertSame([], Arr::toArray(false));
    }

    /**
     * Test toArray by string single.
     */
    public function testToArrayByStringSingle(): void
    {
        $this->assertSame(['a'], Arr::toArray('a'));
    }

    /**
     * Test toJson pretty pring.
     */
    public function testToJsonPrettyPrint(): void
    {
        $data = [
            'string' => 'test',
            'bool' => false,
            'null' => null,
            'array' => [1, 2, 3, 4],
            'path' => '/home/test/this/is/i/path'
        ];
        $json = Arr::toJson($data);
        $this->assertSame(json_encode($data, JSON_UNESCAPED_SLASHES + JSON_PRETTY_PRINT), $json);
    }

    /**
     * Test toJson compact.
     */
    public function testToJsonCompact(): void
    {
        $data = [
            'string' => 'test',
            'bool' => false,
            'null' => null,
            'array' => [1, 2, 3, 4],
            'path' => '/home/test/this/is/i/path'
        ];
        $json = Arr::toJson($data, false);
        $this->assertSame(json_encode($data, JSON_UNESCAPED_SLASHES), $json);
    }

    /**
     * Test toJson slashed.
     */
    public function testToJsonSlashed(): void
    {
        $data = [
            'string' => 'test',
            'bool' => false,
            'null' => null,
            'array' => [1, 2, 3, 4],
            'path' => '/home/test/this/is/i/path'
        ];
        $json = Arr::toJson($data, true, false);
        $this->assertSame(json_encode($data, JSON_PRETTY_PRINT), $json);
    }
}
