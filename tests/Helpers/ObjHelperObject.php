<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

// CodeSniffer will fail on this file on purpose.
class ObjHelperObject
{
    private ?string $property1 = 'property 1';
    private string $property2 = 'property 2';
    private string $property3 = 'property 3';
    private string $property4 = 'property 4';

    /**
     * Public method.
     */
    public function publicMethod(): void
    {
        // Used for testing.
    }

    /**
     * Protected method.
     */
    protected function protectedMethod(): void
    {
        // Used for testing.
    }

    /**
     * Private method.
     */
    private function privateMethod(): void
    {
        // Used for testing.
    }
}