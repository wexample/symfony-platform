<?php

namespace Wexample\SymfonyPlatform;

use Wexample\SymfonyHelpers\Class\AbstractBundle;
use Wexample\SymfonyPseudocode\Interface\PseudocodeBundleInterface;

class WexampleSymfonyPlatformBundle extends AbstractBundle implements PseudocodeBundleInterface
{
    public static function getPseudocodeSourcePaths(): array
    {
        return [__DIR__.'/'];
    }
}
