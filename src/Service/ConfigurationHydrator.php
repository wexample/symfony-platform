<?php

namespace Wexample\SymfonyPlatform\Service;

use Wexample\SymfonyPlatform\Entity\Configuration;

/**
 * Translates a configuration between a plain array and its record, both ways.
 *
 * Where that array is read from and written to is not known here: this package
 * says what a configuration is made of, and something else says where the
 * records live.
 */
final readonly class ConfigurationHydrator
{
    public const KEY_KEY = 'key';
    public const KEY_PRELOAD = 'preload';
    public const KEY_VALUE = 'value';

    /**
     * @param array<string, mixed> $values
     */
    public function hydrate(
        Configuration $configuration,
        array $values
    ): Configuration {
        return $configuration
            ->setKey($values[self::KEY_KEY] ?? '')
            ->setValue($values[self::KEY_VALUE] ?? null)
            ->setPreload((bool) ($values[self::KEY_PRELOAD] ?? false));
    }

    /**
     * @return array<string, mixed>
     */
    public function dump(Configuration $configuration): array
    {
        return [
            self::KEY_KEY => $configuration->getKey(),
            self::KEY_VALUE => $configuration->getValue(),
            self::KEY_PRELOAD => $configuration->isPreload(),
        ];
    }
}
