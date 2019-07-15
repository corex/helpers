<?php

declare(strict_types=1);

namespace CoRex\Helpers;

use Exception;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class Obj
{
    public const PROPERTY_PRIVATE = ReflectionProperty::IS_PRIVATE;
    public const PROPERTY_PROTECTED = ReflectionProperty::IS_PROTECTED;
    public const PROPERTY_PUBLIC = ReflectionProperty::IS_PUBLIC;

    /**
     * Get constants.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getConstants($objectOrClass): array
    {
        try {
            $reflectionClass = self::getReflectionClass($objectOrClass);
            return $reflectionClass->getConstants();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get public constants.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getPublicConstants($objectOrClass): array
    {
        try {
            $reflectionClass = self::getReflectionClass($objectOrClass);
            $constants = $reflectionClass->getConstants();

            // Loop to find constants.
            $result = [];
            foreach ($constants as $name => $value) {
                $reflectionClassConstant = new \ReflectionClassConstant($objectOrClass, $name);
                if ($reflectionClassConstant->isPublic()) {
                    $result[$name] = $value;
                }
            }

            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get private constants.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getPrivateConstants($objectOrClass): array
    {
        try {
            $reflectionClass = self::getReflectionClass($objectOrClass);
            $constants = $reflectionClass->getConstants();

            // Loop to find constants.
            $result = [];
            foreach ($constants as $name => $value) {
                $reflectionClassConstant = new \ReflectionClassConstant($objectOrClass, $name);
                if ($reflectionClassConstant->isPrivate()) {
                    $result[$name] = $value;
                }
            }

            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get properties.
     *
     * @param object $object
     * @param string $classOverride Default null which means class from $object.
     * @param int $propertyType Default null.
     * @return string[]
     * @throws \ReflectionException
     */
    public static function getProperties(
        ?object $object,
        ?string $classOverride = null,
        ?int $propertyType = null
    ): array {
        $reflectionClass = self::getReflectionClass($object, $classOverride);
        $properties = [];
        $reflectionProperties = $reflectionClass->getProperties($propertyType);
        foreach ($reflectionProperties as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($object);
        }
        return $properties;
    }

    /**
     * Get property.
     *
     * @param string $property
     * @param object $object
     * @param mixed $defaultValue Default null.
     * @param string $classOverride Default null which means class from $object.
     * @return mixed
     * @throws \ReflectionException
     */
    public static function getProperty(
        string $property,
        ?object $object,
        $defaultValue = null,
        ?string $classOverride = null
    ) {
        $reflectionClass = self::getReflectionClass($object, $classOverride);
        try {
            $property = $reflectionClass->getProperty($property);
            if ($object === null && !$property->isStatic()) {
                return $defaultValue;
            }
            $property->setAccessible(true);
            return $property->getValue($object);
        } catch (Exception $e) {
            return $defaultValue;
        }
    }

    /**
     * Set properties.
     *
     * @param object $object
     * @param string[] $propertiesValues Key/value.
     * @param string $classOverride Default null which means class from $object.
     * @return bool
     * @throws \ReflectionException
     */
    public static function setProperties(object $object, array $propertiesValues, ?string $classOverride = null): bool
    {
        $reflectionClass = self::getReflectionClass($object, $classOverride);
        if (count($propertiesValues) === 0) {
            return false;
        }
        try {
            foreach ($propertiesValues as $property => $value) {
                $property = $reflectionClass->getProperty($property);
                $property->setAccessible(true);
                $property->setValue($object, $value);
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Set property.
     *
     * @param string $property
     * @param object $object
     * @param mixed $value
     * @param string $classOverride Default null which means class from $object.
     * @return bool
     * @throws \ReflectionException
     */
    public static function setProperty(string $property, ?object $object, $value, ?string $classOverride = null): bool
    {
        $reflectionClass = self::getReflectionClass($object, $classOverride);
        try {
            $property = $reflectionClass->getProperty($property);
            $property->setAccessible(true);
            $property->setValue($object, $value);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Call method.
     *
     * @param string $name
     * @param object $object
     * @param string[] $arguments Default [].
     * @param string $classOverride Default null.
     * @return mixed
     * @throws \ReflectionException
     */
    public static function callMethod(
        string $name,
        ?object $object,
        array $arguments = [],
        ?string $classOverride = null
    ) {
        $method = self::getReflectionMethod($name, $object, $classOverride);
        $method->setAccessible(true);
        if (count($arguments) > 0) {
            return $method->invokeArgs($object, $arguments);
        }
        return $method->invoke($object);
    }

    /**
     * Get interfaces.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getInterfaces($objectOrClass): array
    {
        if (is_object($objectOrClass)) {
            $objectOrClass = get_class($objectOrClass);
        }
        return class_implements($objectOrClass);
    }

    /**
     * Has interface.
     *
     * @param object|string $objectOrClass
     * @param string $interfaceClassName
     * @return bool
     */
    public static function hasInterface($objectOrClass, string $interfaceClassName): bool
    {
        return in_array($interfaceClassName, self::getInterfaces($objectOrClass));
    }

    /**
     * Get extends.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getExtends($objectOrClass): array
    {
        if (is_object($objectOrClass)) {
            $objectOrClass = get_class($objectOrClass);
        }
        return array_values(class_parents($objectOrClass));
    }

    /**
     * Has extends.
     *
     * @param object|string $objectOrClass
     * @param string $class
     * @return bool
     */
    public static function hasExtends($objectOrClass, string $class): bool
    {
        return in_array($class, self::getExtends($objectOrClass));
    }

    /**
     * Has method.
     *
     * @param string $method
     * @param object|string $objectOrClass
     * @return bool
     */
    public static function hasMethod(string $method, $objectOrClass): bool
    {
        try {
            $reflectionClass = self::getReflectionClass($objectOrClass);
            return $reflectionClass->hasMethod($method);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get reflection class.
     *
     * @param object|string $objectOrClass
     * @param string $classOverride Default null which means class from $object.
     * @return ReflectionClass
     * @throws \ReflectionException
     */
    private static function getReflectionClass($objectOrClass, $classOverride = null): ReflectionClass
    {
        $class = $classOverride;
        if ($class === null) {
            if (is_object($objectOrClass)) {
                $class = get_class($objectOrClass);
            } else {
                $class = $objectOrClass;
            }
        }
        return new ReflectionClass($class);
    }

    /**
     * Get reflection method.
     *
     * @param string $method
     * @param object|string $objectOrClass
     * @param string $classOverride Default null which means class from $object.
     * @return ReflectionMethod
     * @throws \ReflectionException
     */
    private static function getReflectionMethod(string $method, $objectOrClass, $classOverride = null): ReflectionMethod
    {
        $class = $classOverride;
        if ($class === null) {
            if (is_object($objectOrClass)) {
                $class = get_class($objectOrClass);
            } else {
                $class = $objectOrClass;
            }
        }
        return new ReflectionMethod($class, $method);
    }
}