<?php

declare(strict_types=1);

namespace Tests\CoRex\Helpers\Helpers;

use CoRex\Helpers\Traits\ConstantsStaticTrait;
use CoRex\Helpers\Traits\DataTrait;

class ClassWithTraits
{
    use ConstantsStaticTrait;
    use DataTrait;
}