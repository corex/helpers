<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

class MethodABCClass implements MethodAInterface, MethodBInterface
{
    public function methodAInInterface(): void
    {
        // Do nothing. Only for testing.
    }

    public function methodBInInterface(): void
    {
        // Do nothing. Only for testing.
    }

    public function methodCNotInInterface(): void
    {
        // Do nothing. Only for testing.
    }

    protected function methodProtected(): void
    {
        // Do nothing. Only for testing.
    }

    private function methodPrivate(): void
    {
        // Do nothing. Only for testing.
    }
}