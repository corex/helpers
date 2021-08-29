<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Traits;

use CoRex\Helpers\Obj;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Tests\CoRex\Helpers\Helpers\ConstantsStatic;

class ConstantsStaticTraitTest extends TestCase
{
    /**
     * Test getClassConstants.
     *
     * @throws ReflectionException
     */
    public function testGetClassConstants(): void
    {
        $constants = $this->callMethod('getClassConstants');
        $this->assertSame(Obj::getConstants(ConstantsStatic::class), $constants);
    }

    /**
     * Test getClassConstantByValue.
     *
     * @throws ReflectionException
     */
    public function testGetClassConstantByValue(): void
    {
        $this->assertSame(
            'ACTOR_LASTNAME',
            $this->callMethod('getClassConstantByValue', ['value' => ConstantsStatic::ACTOR_LASTNAME])
        );
        $this->assertNull($this->callMethod('getClassConstantByValue', ['value' => 'unknown']));
    }

    /**
     * Test getPublicClassConstants.
     *
     * @throws ReflectionException
     */
    public function testGetPublicClassConstants(): void
    {
        $constants = $this->callMethod('getPublicClassConstants');
        $this->assertSame(Obj::getPublicConstants(ConstantsStatic::class), $constants);
    }

    /**
     * Test getPublicClassConstantByValue.
     *
     * @throws ReflectionException
     */
    public function testGetPublicClassConstantByValue(): void
    {
        $this->assertSame(
            'ACTOR_LASTNAME',
            $this->callMethod('getPublicClassConstantByValue', ['value' => ConstantsStatic::ACTOR_LASTNAME])
        );
        $this->assertNull($this->callMethod('getPublicClassConstantByValue', ['value' => 'unknown']));
    }

    /**
     * Test getPrivateClassConstants.
     *
     * @throws ReflectionException
     */
    public function testGetPrivateClassConstants(): void
    {
        $constants = $this->callMethod('getPrivateClassConstants');
        $this->assertSame(Obj::getPrivateConstants(ConstantsStatic::class), $constants);
    }

    /**
     * Test getPrivateClassConstantByValue.
     *
     * @throws ReflectionException
     */
    public function testGetPrivateClassConstantByValue(): void
    {
        $this->assertSame(
            'PRIVATE_LASTNAME',
            $this->callMethod('getPrivateClassConstantByValue', ['value' => 'Connery'])
        );
        $this->assertNull($this->callMethod('getPrivateClassConstantByValue', ['value' => 'unknown']));
    }

    /**
     * Test hasConstant.
     *
     * @throws ReflectionException
     */
    public function testHasConstant(): void
    {
        $this->assertFalse($this->callMethod('hasClassConstant', ['constantName' => 'unknown']));
        $this->assertTrue($this->callMethod('hasClassConstant', ['constantName' => 'ACTOR_FIRSTNAME']));
        $this->assertTrue($this->callMethod('hasClassConstant', ['constantName' => 'PRIVATE_FIRSTNAME']));
    }

    /**
     * Test hasConstantByValue.
     *
     * @throws ReflectionException
     */
    public function testHasConstantByValue(): void
    {
        $this->assertFalse($this->callMethod('hasClassConstantByValue', ['value' => 'unknown']));
        $this->assertTrue($this->callMethod(
            'hasClassConstantByValue',
            ['value' => ConstantsStatic::ACTOR_FIRSTNAME]
        ));
        $this->assertTrue($this->callMethod('hasClassConstantByValue', ['value' => 'Connery']));
    }

    /**
     * Test hasPublicConstant.
     *
     * @throws ReflectionException
     */
    public function testHasPublicConstant(): void
    {
        $this->assertFalse($this->callMethod('hasPublicClassConstant', ['constantName' => 'unknown']));
        $this->assertTrue($this->callMethod('hasPublicClassConstant', ['constantName' => 'ACTOR_FIRSTNAME']));
        $this->assertFalse($this->callMethod('hasPublicClassConstant', ['constantName' => 'PRIVATE_FIRSTNAME']));
    }

    /**
     * Test hasPublicConstantByValue.
     *
     * @throws ReflectionException
     */
    public function testHasPublicConstantByValue(): void
    {
        $this->assertFalse($this->callMethod('hasPublicClassConstantByValue', ['value' => 'unknown']));
        $this->assertTrue($this->callMethod(
            'hasPublicClassConstantByValue',
            ['value' => ConstantsStatic::ACTOR_FIRSTNAME]
        ));
        $this->assertFalse($this->callMethod('hasPublicClassConstantByValue', ['value' => 'Connery']));
    }

    /**
     * Test hasPrivateConstant.
     *
     * @throws ReflectionException
     */
    public function testHasPrivateConstant(): void
    {
        $this->assertFalse($this->callMethod('hasPrivateClassConstant', ['constantName' => 'unknown']));
        $this->assertFalse($this->callMethod('hasPrivateClassConstant', ['constantName' => 'ACTOR_FIRSTNAME']));
        $this->assertTrue($this->callMethod('hasPrivateClassConstant', ['constantName' => 'PRIVATE_FIRSTNAME']));
    }

    /**
     * Test hasPrivateConstantByValue.
     *
     * @throws ReflectionException
     */
    public function testHasPrivateConstantByValue(): void
    {
        $this->assertFalse($this->callMethod('hasPrivateClassConstantByValue', ['value' => 'unknown']));
        $this->assertFalse($this->callMethod(
            'hasPrivateClassConstantByValue',
            ['value' => ConstantsStatic::ACTOR_FIRSTNAME]
        ));
        $this->assertTrue($this->callMethod('hasPrivateClassConstantByValue', ['value' => 'Connery']));
    }

    /**
     * Call method.
     *
     * @param string $method
     * @param string[] $arguments
     * @return mixed
     * @throws ReflectionException
     */
    private function callMethod(string $method, array $arguments = [])
    {
        return Obj::callMethod($method, null, $arguments, ConstantsStatic::class);
    }
}