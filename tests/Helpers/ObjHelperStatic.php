<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

// CodeSniffer will fail on this file on purpose.
class ObjHelperStatic
{
    /** @var string */
    private static $property1 = 'property 1';

    /** @var string */
    private static $property2 = 'property 2';

    /** @var string */
    private static $property3 = 'property 3';

    /** @var string */
    private static $property4 = 'property 4';

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