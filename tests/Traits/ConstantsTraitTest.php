<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Traits;

use CoRex\Helpers\Obj;
use PHPUnit\Framework\TestCase;
use Tests\CoRex\Helpers\Helpers\Constants;

class ConstantsTraitTest extends TestCase
{
    /** @var Constants */
    private $constants;

    /**
     * Test getClassConstants.
     *
     * @throws \ReflectionException
     */
    public function testGetClassConstants(): void
    {
        $constants = $this->callMethod('getClassConstants');
        $this->assertEquals(Obj::getConstants($this->constants), $constants);
    }

    /**
     * Test getPublicClassConstants.
     *
     * @throws \ReflectionException
     */
    public function testGetPublicClassConstants(): void
    {
        $constants = $this->callMethod('getPublicClassConstants');
        $this->assertEquals(Obj::getPublicConstants($this->constants), $constants);
    }

    /**
     * Test getPrivateClassConstants.
     *
     * @throws \ReflectionException
     */
    public function testGetPrivateClassConstants(): void
    {
        $constants = $this->callMethod('getPrivateClassConstants');
        $this->assertEquals(Obj::getPrivateConstants($this->constants), $constants);
    }

    /**
     * Test hasConstant.
     *
     * @throws \ReflectionException
     */
    public function testHasConstant(): void
    {
        $this->assertFalse($this->callMethod('hasClassConstant', ['constantName' => 'unknown']));
        $this->assertTrue($this->callMethod('hasClassConstant', ['constantName' => 'ACTOR_FIRSTNAME']));
        $this->assertTrue($this->callMethod('hasClassConstant', ['constantName' => 'PRIVATE_FIRSTNAME']));
    }

    /**
     * Test hasPublicConstant.
     *
     * @throws \ReflectionException
     */
    public function testHasPublicConstant(): void
    {
        $this->assertFalse($this->callMethod('hasPublicClassConstant', ['constantName' => 'unknown']));
        $this->assertTrue($this->callMethod('hasPublicClassConstant', ['constantName' => 'ACTOR_FIRSTNAME']));
        $this->assertFalse($this->callMethod('hasPublicClassConstant', ['constantName' => 'PRIVATE_FIRSTNAME']));
    }

    /**
     * Test hasPrivateConstant.
     *
     * @throws \ReflectionException
     */
    public function testHasPrivateConstant(): void
    {
        $this->assertFalse($this->callMethod('hasPrivateClassConstant', ['constantName' => 'unknown']));
        $this->assertFalse($this->callMethod('hasPrivateClassConstant', ['constantName' => 'ACTOR_FIRSTNAME']));
        $this->assertTrue($this->callMethod('hasPrivateClassConstant', ['constantName' => 'PRIVATE_FIRSTNAME']));
    }

    /**
     * Call method..
     *
     * @param string $method
     * @param string[] $arguments
     * @return mixed
     * @throws \ReflectionException
     */
    private function callMethod(string $method, array $arguments = [])
    {
        return Obj::callMethod($method, $this->constants, $arguments);
    }

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->constants = new Constants();
    }
}