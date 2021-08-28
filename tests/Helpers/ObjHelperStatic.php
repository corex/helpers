<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

// CodeSniffer will fail on this file on purpose.
class ObjHelperStatic
{
    private static string $property1 = 'property 1';
    private static string $property2 = 'property 2';
    private static string $property3 = 'property 3';
    private static string $property4 = 'property 4';

    /**
     * Private method.
     *
     * @param string $arguments
     * @return string
     */
    private static function privateMethod(string $arguments = ''): string
    {
        return '(' . __FUNCTION__ . ')' . $arguments;
    }
}