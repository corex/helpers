<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers;

use CoRex\Helpers\Obj;
use CoRex\Helpers\Traits\ConstantsStaticTrait;
use CoRex\Helpers\Traits\ConstantsTrait;
use CoRex\Helpers\Traits\DataTrait;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Tests\CoRex\Helpers\Helpers\ClassWithTraits;
use Tests\CoRex\Helpers\Helpers\Constants;
use Tests\CoRex\Helpers\Helpers\ObjHelperInterface;
use Tests\CoRex\Helpers\Helpers\ObjHelperObject;
use Tests\CoRex\Helpers\Helpers\ObjHelperObjectExtended;
use Tests\CoRex\Helpers\Helpers\ObjHelperStatic;
use Tests\CoRex\Helpers\Helpers\ObjHelperWithInterface;
use Tests\CoRex\Helpers\Helpers\ObjHelperWithoutInterface;

class ObjTest extends TestCase
{
    /** @var string[] */
    private $checkProperties = [
        'property1' => 'property 1',
        'property2' => 'property 2',
        'property3' => 'property 3',
        'property4' => 'property 4'
    ];

    /**
     * Test getConstants.
     */
    public function testGetConstants(): void
    {
        $this->assertEquals([
            'ACTOR_FIRSTNAME' => Constants::ACTOR_FIRSTNAME,
            'ACTOR_LASTNAME' => Constants::ACTOR_LASTNAME,
            'PRIVATE_FIRSTNAME' => 'Sean',
            'PRIVATE_LASTNAME' => 'Connery',
            'FIRSTNAME' => Constants::FIRSTNAME,
            'LASTNAME' => Constants::LASTNAME
        ], Obj::getConstants(Constants::class));
    }

    /**
     * Test getConstants failure.
     */
    public function testGetConstantsFailure(): void
    {
        $this->assertEquals([], Obj::getConstants('unknown'));
    }

    /**
     * Test getPublicConstants.
     */
    public function testGetPublicConstants(): void
    {
        $this->assertEquals([
            'ACTOR_FIRSTNAME' => Constants::ACTOR_FIRSTNAME,
            'ACTOR_LASTNAME' => Constants::ACTOR_LASTNAME,
            'FIRSTNAME' => Constants::FIRSTNAME,
            'LASTNAME' => Constants::LASTNAME
        ], Obj::getPublicConstants(Constants::class));
    }

    /**
     * Test getPublicConstants failure.
     */
    public function testGetPublicConstantsFailure(): void
    {
        $this->assertEquals([], Obj::getPublicConstants('unknown'));
    }

    /**
     * Test getPrivateConstants.
     */
    public function testGetPrivateConstants(): void
    {
        $this->assertEquals([
            'PRIVATE_FIRSTNAME' => 'Sean',
            'PRIVATE_LASTNAME' => 'Connery'
        ], Obj::getPrivateConstants(Constants::class));
    }

    /**
     * Test getPrivateConstants failure.
     */
    public function testGetPrivateConstantsFailure(): void
    {
        $this->assertEquals([], Obj::getPrivateConstants('unknown'));
    }

    /**
     * Test get private properties from object.
     *
     * @throws ReflectionException
     */
    public function testGetPrivatePropertiesFromObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $properties = Obj::getProperties($objHelperObject, null, Obj::PROPERTY_PRIVATE);
        $this->assertEquals($this->checkProperties, $properties);
    }

    /**
     * Test get private properties from static.
     *
     * @throws ReflectionException
     */
    public function testGetPrivatePropertiesFromStatic(): void
    {
        $properties = Obj::getProperties(null, ObjHelperStatic::class, Obj::PROPERTY_PRIVATE);
        $this->assertEquals($this->checkProperties, $properties);
    }

    /**
     * Test get interfaces with from object.
     */
    public function testGetInterfacesWithFromObject(): void
    {
        $objHelperWithInterface = new ObjHelperWithInterface();
        $interfaces = Obj::getInterfaces($objHelperWithInterface);
        $this->assertArrayHasKey(ObjHelperInterface::class, $interfaces);
    }

    /**
     * Test get interfaces with from class.
     */
    public function testGetInterfacesWithFromClass(): void
    {
        $interfaces = Obj::getInterfaces(ObjHelperWithInterface::class);
        $this->assertArrayHasKey(ObjHelperInterface::class, $interfaces);
    }

    /**
     * Test get interfaces without from object.
     */
    public function testGetInterfacesWithoutFromObject(): void
    {
        $objHelperWithoutInterface = new ObjHelperWithoutInterface();
        $interfaces = Obj::getInterfaces($objHelperWithoutInterface);
        $this->assertArrayNotHasKey(ObjHelperInterface::class, $interfaces);
    }

    /**
     * Test get interfaces without from class.
     */
    public function testGetInterfacesWithoutFromClass(): void
    {
        $interfaces = Obj::getInterfaces(ObjHelperWithoutInterface::class);
        $this->assertArrayNotHasKey(ObjHelperInterface::class, $interfaces);
    }

    /**
     * Test has interface with from object.
     */
    public function testHasInterfaceWithFromObject(): void
    {
        $objHelperWithInterface = new ObjHelperWithInterface();
        $this->assertTrue(Obj::hasInterface($objHelperWithInterface, ObjHelperInterface::class));
    }

    /**
     * Test has interface with from class.
     */
    public function testHasInterfaceWithFromClass(): void
    {
        $this->assertTrue(Obj::hasInterface(ObjHelperWithInterface::class, ObjHelperInterface::class));
    }

    /**
     * Test has interface without from object.
     */
    public function testHasInterfaceWithoutFromObject(): void
    {
        $objHelperWithoutInterface = new ObjHelperWithoutInterface();
        $this->assertFalse(Obj::hasInterface($objHelperWithoutInterface, ObjHelperInterface::class));
    }

    /**
     * Test has interface without from class.
     */
    public function testHasInterfaceWithoutFromClass(): void
    {
        $this->assertFalse(Obj::hasInterface(ObjHelperWithoutInterface::class, ObjHelperInterface::class));
    }

    /**
     * Test getExtends with from object.
     */
    public function testGetExtendsWithFromObject(): void
    {
        $objHelperObjectExtended = new ObjHelperObjectExtended();
        $extends = Obj::getExtends($objHelperObjectExtended);
        $this->assertTrue(in_array(ObjHelperObject::class, $extends));
    }

    /**
     * Test getExtends with from class.
     */
    public function testGetExtendsWithFromClass(): void
    {
        $extends = Obj::getExtends(ObjHelperObjectExtended::class);
        $this->assertTrue(in_array(ObjHelperObject::class, $extends));
    }

    /**
     * Test getExtends without from object.
     */
    public function testGetExtendsWithoutFromObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $extends = Obj::getExtends($objHelperObject);
        $this->assertEquals([], $extends);
    }

    /**
     * Test getExtends without from class.
     */
    public function testGetExtendsWithoutFromClass(): void
    {
        $extends = Obj::getExtends(ObjHelperObject::class);
        $this->assertEquals([], $extends);
    }

    /**
     * Test hasExtends with from object.
     */
    public function testHasExtendsWithFromObject(): void
    {
        $objHelperObjectExtended = new ObjHelperObjectExtended();
        $this->assertTrue(Obj::hasExtends($objHelperObjectExtended, ObjHelperObject::class));
    }

    /**
     * Test hasExtends with from class.
     */
    public function testHasExtendsWithFromClass(): void
    {
        $this->assertTrue(Obj::hasExtends(ObjHelperObjectExtended::class, ObjHelperObject::class));
    }

    /**
     * Test hasExtends without from object.
     */
    public function testHasExtendsWithoutFromObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $this->assertFalse(Obj::hasExtends($objHelperObject, ObjHelperObject::class));
    }

    /**
     * Test hasExtends without from class.
     */
    public function testHasExtendsWithoutFromClass(): void
    {
        $this->assertFalse(Obj::hasExtends(ObjHelperObject::class, ObjHelperObject::class));
    }

    /**
     * Test hasMethod private from object.
     */
    public function testHasMethodPrivateFromObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $this->assertTrue(Obj::hasMethod('privateMethod', $objHelperObject));
    }

    /**
     * Test hasMethod protected from object.
     */
    public function testHasMethodProtectedFromObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $this->assertTrue(Obj::hasMethod('protectedMethod', $objHelperObject));
    }

    /**
     * Test hasMethod public from object.
     */
    public function testHasMethodPublicFromObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $this->assertTrue(Obj::hasMethod('publicMethod', $objHelperObject));
    }

    /**
     * Test hasMethod private from class.
     */
    public function testHasMethodPrivateFromClass(): void
    {
        $this->assertTrue(Obj::hasMethod('privateMethod', ObjHelperObject::class));
    }

    /**
     * Test hasMethod protected from class.
     */
    public function testHasMethodProtectedFromClass(): void
    {
        $this->assertTrue(Obj::hasMethod('protectedMethod', ObjHelperObject::class));
    }

    /**
     * Test hasMethod public from class.
     */
    public function testHasMethodPublicFromClass(): void
    {
        $this->assertTrue(Obj::hasMethod('publicMethod', ObjHelperObject::class));
    }

    /**
     * Test hasMethod private from extended class.
     */
    public function testHasMethodPrivateFromExtendedClass(): void
    {
        $this->assertTrue(Obj::hasMethod('privateMethod', ObjHelperObjectExtended::class));
    }

    /**
     * Test hasMethod protected from extended class.
     */
    public function testHasMethodProtectedFromExtendedClass(): void
    {
        $this->assertTrue(Obj::hasMethod('protectedMethod', ObjHelperObjectExtended::class));
    }

    /**
     * Test hasMethod public from extended class.
     */
    public function testHasMethodPublicFromExtendedClass(): void
    {
        $this->assertTrue(Obj::hasMethod('publicMethod', ObjHelperObjectExtended::class));
    }

    /**
     * Test hasMethod no class.
     */
    public function testHasMethodNoClass(): void
    {
        $this->assertFalse(Obj::hasMethod('unknown', 'unknown'));
    }

    /**
     * Test set property.
     *
     * @throws ReflectionException
     */
    public function testSetPropertyFound(): void
    {
        $check1 = md5((string)microtime(true)) . '1';
        $check2 = md5((string)microtime(true)) . '2';
        $check3 = md5((string)microtime(true)) . '3';
        $check4 = md5((string)microtime(true)) . '4';

        $objHelperObject = new ObjHelperObject();
        $this->assertTrue(Obj::setProperty('property1', $objHelperObject, $check1));
        $this->assertTrue(Obj::setProperty('property2', $objHelperObject, $check2));
        $this->assertTrue(Obj::setProperty('property3', $objHelperObject, $check3));
        $this->assertTrue(Obj::setProperty('property4', $objHelperObject, $check4));

        $properties = Obj::getProperties($objHelperObject, null, Obj::PROPERTY_PRIVATE);
        $this->assertEquals($check1, $properties['property1']);
        $this->assertEquals($check2, $properties['property2']);
        $this->assertEquals($check3, $properties['property3']);
        $this->assertEquals($check4, $properties['property4']);
    }

    /**
     * Test set property not found.
     *
     * @throws ReflectionException
     */
    public function testSetPropertyNotFound(): void
    {
        $check = md5((string)microtime(true));
        $objHelperObject = new ObjHelperObject();
        $property = Obj::setProperty('unknown', $objHelperObject, $check);
        $this->assertFalse($property);
    }

    /**
     * Test get property not found.
     *
     * @throws ReflectionException
     */
    public function testGetPropertyNotFound(): void
    {
        $check = md5((string)microtime(true));
        $objHelperObject = new ObjHelperObject();
        $property = Obj::getProperty('unknown', $objHelperObject, $check);
        $this->assertEquals($check, $property);
    }

    /**
     * Test get property found.
     *
     * @throws ReflectionException
     */
    public function testGetPropertyFound(): void
    {
        $check1 = md5((string)microtime(true));
        $check2 = md5((string)microtime(true));
        $objHelperObject = new ObjHelperObject();
        Obj::setProperty('property1', $objHelperObject, $check1);
        Obj::setProperty('property2', $objHelperObject, $check2);
        $this->assertEquals($check1, Obj::getProperty('property1', $objHelperObject));
        $this->assertEquals($check2, Obj::getProperty('property2', $objHelperObject));
    }

    /**
     * Test get property found static.
     *
     * @throws ReflectionException
     */
    public function testGetPropertyFoundStatic(): void
    {
        $check1 = md5((string)mt_rand(1, 100000));
        $check2 = md5((string)mt_rand(1, 100000));
        $check3 = md5((string)mt_rand(1, 100000));
        $check4 = md5((string)mt_rand(1, 100000));
        Obj::setProperty('property1', null, $check1, ObjHelperStatic::class);
        Obj::setProperty('property2', null, $check2, ObjHelperStatic::class);
        Obj::setProperty('property3', null, $check3, ObjHelperStatic::class);
        Obj::setProperty('property4', null, $check4, ObjHelperStatic::class);
        $value1 = Obj::getProperty('property1', null, null, ObjHelperStatic::class);
        $value2 = Obj::getProperty('property2', null, null, ObjHelperStatic::class);
        $value3 = Obj::getProperty('property3', null, null, ObjHelperStatic::class);
        $value4 = Obj::getProperty('property4', null, null, ObjHelperStatic::class);
        $this->assertEquals($check1, $value1);
        $this->assertEquals($check2, $value2);
        $this->assertEquals($check3, $value3);
        $this->assertEquals($check4, $value4);
    }

    /**
     * Test get property found static null.
     *
     * @throws ReflectionException
     */
    public function testGetPropertyFoundStaticNull(): void
    {
        $objHelperObject = new ObjHelperObject();
        Obj::setProperty('property1', $objHelperObject, null);
        $value1 = Obj::getProperty('property1', null, null, ObjHelperObject::class);
        $this->assertNull($value1);
    }

    /**
     * Test set properties.
     *
     * @throws ReflectionException
     */
    public function testSetPropertiesFound(): void
    {
        $propertiesValues = [
            'property1' => md5((string)microtime(true)) . '1',
            'property2' => md5((string)microtime(true)) . '2',
            'property3' => md5((string)microtime(true)) . '3',
            'property4' => md5((string)microtime(true)) . '4'
        ];
        $objHelperObject = new ObjHelperObject();
        Obj::setProperties($objHelperObject, $propertiesValues);
        $properties = Obj::getProperties($objHelperObject, null, Obj::PROPERTY_PRIVATE);
        $this->assertEquals($propertiesValues, $properties);
    }

    /**
     * Test set properties one not found.
     *
     * @throws ReflectionException
     */
    public function testSetPropertiesOneNotFound(): void
    {
        $propertiesValues = [
            'property1' => md5((string)microtime(true)) . '1',
            'unknown' => md5((string)microtime(true)),
            'property3' => md5((string)microtime(true)) . '3',
            'property4' => md5((string)microtime(true)) . '4'
        ];
        $objHelperObject = new ObjHelperObject();
        $this->assertFalse(Obj::setProperties($objHelperObject, $propertiesValues));
    }

    /**
     * Test set properties empty.
     *
     * @throws ReflectionException
     */
    public function testSetPropertiesEmpty(): void
    {
        $objHelperObject = new ObjHelperObject();
        $this->assertFalse(Obj::setProperties($objHelperObject, []));
    }

    /**
     * Test callMethod private static.
     *
     * @throws ReflectionException
     */
    public function testCallMethodPrivateStatic(): void
    {
        $method = 'privateMethod';
        $check = Obj::callMethod($method, null, [], ObjHelperStatic::class);
        $this->assertEquals('(' . $method . ')', $check);
    }

    /**
     * Test callMethod private static.
     *
     * @throws ReflectionException
     */
    public function testCallMethodPrivateStaticWithArguments(): void
    {
        $method = 'privateMethod';
        $check = Obj::callMethod($method, null, [
            'arguments' => '.test'
        ], ObjHelperStatic::class);
        $this->assertEquals('(' . $method . ').test', $check);
    }

    /**
     * Test get traits.
     */
    public function testGetTraits(): void
    {
        $traits = Obj::getTraits(ClassWithTraits::class);
        $this->assertTrue(in_array(ConstantsStaticTrait::class, $traits));
        $this->assertTrue(in_array(DataTrait::class, $traits));
        $this->assertFalse(in_array(ConstantsTrait::class, $traits));
    }

    /**
     * Test get traits object.
     */
    public function testGetTraitsObject(): void
    {
        $classWithTraits = new ClassWithTraits();
        $traits = Obj::getTraits($classWithTraits);
        $this->assertTrue(in_array(ConstantsStaticTrait::class, $traits));
        $this->assertTrue(in_array(DataTrait::class, $traits));
        $this->assertFalse(in_array(ConstantsTrait::class, $traits));
    }

    /**
     * Test get traits none.
     */
    public function testGetTraitsNone(): void
    {
        $traits = Obj::getTraits(ObjHelperObject::class);
        $this->assertTrue(count($traits) === 0);
    }

    /**
     * Test has trait.
     */
    public function testHasTrait(): void
    {
        $this->assertTrue(Obj::hasTrait(ClassWithTraits::class, ConstantsStaticTrait::class));
        $this->assertTrue(Obj::hasTrait(ClassWithTraits::class, DataTrait::class));
        $this->assertFalse(Obj::hasTrait(ClassWithTraits::class, ConstantsTrait::class));
    }

    /**
     * Test getReflectionClass by object.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionClassByObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $reflectionClass = $this->getReflectionClassFromObj($objHelperObject);
        $this->assertEquals(ObjHelperObject::class, $reflectionClass->getName());
    }

    /**
     * Test getReflectionClass by class.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionClassByClass(): void
    {
        $reflectionClass = $this->getReflectionClassFromObj(ObjHelperObject::class);
        $this->assertEquals(ObjHelperObject::class, $reflectionClass->getName());
    }

    /**
     * Test getReflectionClass by object override.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionClassByByObjectOverride(): void
    {
        $objHelperObjectExtended = new ObjHelperObjectExtended();
        $reflectionClass = $this->getReflectionClassFromObj($objHelperObjectExtended, ObjHelperObject::class);
        $this->assertEquals(ObjHelperObject::class, $reflectionClass->getName());
    }

    /**
     * Test getReflectionClass by class override.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionClassByByClassOverride(): void
    {
        $reflectionClass = $this->getReflectionClassFromObj(ObjHelperObjectExtended::class, ObjHelperObject::class);
        $this->assertEquals(ObjHelperObject::class, $reflectionClass->getName());
    }

    /**
     * Test getReflectionMethod by object.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionMethodByObject(): void
    {
        $objHelperObject = new ObjHelperObject();
        $reflectionMethod = $this->getReflectionMethodFromObj('privateMethod', $objHelperObject);
        $this->assertEquals('privateMethod', $reflectionMethod->name);
        $this->assertEquals(ObjHelperObject::class, Obj::getProperty('class', $reflectionMethod));
    }

    /**
     * Test getReflectionMethod by class.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionMethodByClass(): void
    {
        $reflectionMethod = $this->getReflectionMethodFromObj('privateMethod', null, ObjHelperObject::class);
        $this->assertEquals('privateMethod', $reflectionMethod->name);
        $this->assertEquals(ObjHelperObject::class, Obj::getProperty('class', $reflectionMethod));
    }

    /**
     * Test getReflectionMethod by object override.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionMethodByByObjectOverride(): void
    {
        $objHelperObjectExtended = new ObjHelperObjectExtended();
        $reflectionMethod = $this->getReflectionMethodFromObj(
            'privateMethod',
            $objHelperObjectExtended,
            ObjHelperObject::class
        );
        $this->assertEquals('privateMethod', $reflectionMethod->name);
        $this->assertEquals(ObjHelperObject::class, Obj::getProperty('class', $reflectionMethod));
    }

    /**
     * Test getReflectionMethod by class override.
     *
     * @throws ReflectionException
     */
    public function testGetReflectionMethodByByClassOverride(): void
    {
        $reflectionMethod = $this->getReflectionMethodFromObj('privateMethod', ObjHelperObjectExtended::class);
        $this->assertEquals('privateMethod', $reflectionMethod->name);
        $this->assertEquals(ObjHelperObject::class, Obj::getProperty('class', $reflectionMethod));
    }

    /**
     * Get reflection class from obj.
     *
     * @param object|string $objectOrClass
     * @param string $classOverride Default null which means class from $object.
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private function getReflectionClassFromObj($objectOrClass, ?string $classOverride = null): ReflectionClass
    {
        $reflectionMethod = new ReflectionMethod(Obj::class, 'getReflectionClass');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs(null, [$objectOrClass, $classOverride]);
    }

    /**
     * Get reflection method from obj.
     *
     * @param string $method
     * @param object|string $objectOrClass
     * @param string $classOverride Default null which means class from $object.
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    private function getReflectionMethodFromObj(
        string $method,
        $objectOrClass,
        ?string $classOverride = null
    ): ReflectionMethod {
        $reflectionMethod = new ReflectionMethod(Obj::class, 'getReflectionMethod');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs(null, [$method, $objectOrClass, $classOverride]);
    }
}
