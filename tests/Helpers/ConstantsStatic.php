<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

use CoRex\Helpers\Traits\ConstantsStaticTrait;

class ConstantsStatic
{
    use ConstantsStaticTrait;

    public const ACTOR_FIRSTNAME = 'Roger';
    public const ACTOR_LASTNAME = 'Moore';
    public const FIRSTNAME = 'Daniel';
    public const LASTNAME = 'Craig';
    private const PRIVATE_FIRSTNAME = 'Sean';
    private const PRIVATE_LASTNAME = 'Connery';
}