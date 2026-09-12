<?php

namespace Wexample\SymfonyPlatform\Entity\Traits\Manipulator;

use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;
use Wexample\SymfonyPlatform\Entity\Configuration;

trait ConfigurationEntityManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return Configuration::class;
    }
}
