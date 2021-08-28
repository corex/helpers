<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

use CoRex\Helpers\Traits\ConstantsTrait;

class Constants
{
    use ConstantsTrait;

    public const PUBLIC_FIRSTNAME = 'Roger';
    public const PUBLIC_LASTNAME = 'Moore';

    protected const PROTECTED_FIRSTNAME = 'Pierce';
    protected const PROTECTED_LASTNAME = 'Brosnan';

    private const PRIVATE_FIRSTNAME = 'Sean';
    private const PRIVATE_LASTNAME = 'Connery';

    // @codingStandardsIgnoreStart
    const ANY_FIRSTNAME = 'Daniel';
    const ANY_LASTNAME = 'Craig';
    // @codingStandardsIgnoreEnd
}