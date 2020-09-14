<?php

declare(strict_types=1);

namespace CoRex\Helpers;

use Exception;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;
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
        return self::getClassConstants($objectOrClass, []);
    }

    /**
     * Get public constants.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getPublicConstants($objectOrClass): array
    {
        return self::getClassConstants($objectOrClass, [self::PROPERTY_PUBLIC]);
    }

    /**
     * Get private constants.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getPrivateConstants($objectOrClass): array
    {
        return self::getClassConstants($objectOrClass, [self::PROPERTY_PRIVATE]);
    }

    /**
     * Get protected constants.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getProtectedConstants($objectOrClass): array
    {
        return self::getClassConstants($objectOrClass, [self::PROPERTY_PROTECTED]);
    }

    /**
     * Get properties.
     *
     * @param object|null $object $object
     * @param string|null $classOverride Default null which means class from $object.
     * @param int|null $propertyType Default null.
     * @return string[]
     * @throws ReflectionException
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
     * @param object|null $object $object
     * @param mixed $defaultValue Default null.
     * @param string|null $classOverride Default null which means class from $object.
     * @return mixed
     * @throws ReflectionException
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
     * @param string|null $classOverride Default null which means class from $object.
     * @return bool
     * @throws ReflectionException
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
     * @param object|null $object $object
     * @param mixed $value
     * @param string|null $classOverride Default null which means class from $object.
     * @return bool
     * @throws ReflectionException
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
     * Call method.
     *
     * @param string $name
     * @param object|null $object $object
     * @param string[] $arguments Default [].
     * @param string|null $classOverride Default null.
     * @return mixed
     * @throws ReflectionException
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
        return in_array($interfaceClassName, self::getInterfaces($objectOrClass), true);
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
     * @param string $extendsClass
     * @return bool
     */
    public static function hasExtends($objectOrClass, string $extendsClass): bool
    {
        return in_array($extendsClass, self::getExtends($objectOrClass), true);
    }

    /**
     * Get traits.
     *
     * @param object|string $objectOrClass
     * @return string[]
     */
    public static function getTraits($objectOrClass): array
    {
        if (is_object($objectOrClass)) {
            $objectOrClass = get_class($objectOrClass);
        }

        return array_values(class_uses($objectOrClass));
    }

    /**
     * Has trait.
     *
     * @param object|string $objectOrTrait
     * @param string $traitClass
     * @return bool
     */
    public static function hasTrait($objectOrTrait, string $traitClass): bool
    {
        return in_array($traitClass, self::getTraits($objectOrTrait), true);
    }

    /**
     * Get class constants by types.
     *
     * @param object|string $objectOrClass
     * @param int[] $types Use ReflectionProperty::IS_*.
     * @return array
     */
    private static function getClassConstants($objectOrClass, array $types): array
    {
        try {
            $reflectionClass = self::getReflectionClass($objectOrClass);
            $constants = $reflectionClass->getConstants();

            // Loop to find constants.
            $result = [];
            foreach ($constants as $name => $value) {
                $reflectionClassConstant = new ReflectionClassConstant($objectOrClass, $name);
                $modifiers = $reflectionClassConstant->getModifiers();

                $doAdd = false;
                if (count($types) > 0) {
                    foreach ($types as $type) {
                        if (($modifiers | $type) === $modifiers) {
                            $doAdd = true;
                        }
                    }
                } else {
                    $doAdd = true;
                }

                if ($doAdd) {
                    $result[$name] = $value;
                }
            }

            return $result;
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * Get reflection class.
     *
     * @param object|string $objectOrClass
     * @param string|null $classOverride Default null which means class from $object.
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private static function getReflectionClass($objectOrClass, ?string $classOverride = null): ReflectionClass
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
     * @param string|null $classOverride Default null which means class from $object.
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    private static function getReflectionMethod(
        string $method,
        $objectOrClass,
        ?string $classOverride = null
    ): ReflectionMethod {
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