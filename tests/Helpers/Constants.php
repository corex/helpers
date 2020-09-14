<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

use CoRex\Helpers\Traits\ConstantsTrait;

class Constants
{
    use ConstantsTrait;

    public const PUBLIC_FIRSTNAME = 'Roger';
    public const PUBLIC_LASTNAME = 'Moore';
    private const PRIVATE_FIRSTNAME = 'Sean';
    private const PRIVATE_LASTNAME = 'Connery';
    protected const PROTECTED_FIRSTNAME = 'Pierce';
    protected const PROTECTED_LASTNAME = 'Brosnan';
    const ANY_FIRSTNAME = 'Daniel';
    const ANY_LASTNAME = 'Craig';
}