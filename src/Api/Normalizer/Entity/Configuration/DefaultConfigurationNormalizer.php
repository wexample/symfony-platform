<?php

namespace Wexample\SymfonyPlatform\Api\Normalizer\Entity\Configuration;

use ArrayObject;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;
use Wexample\SymfonyPlatform\Api\Dto\ConfigurationDto;
use Wexample\SymfonyPlatform\Entity\Configuration;
use Wexample\SymfonyPlatform\Entity\Traits\Manipulator\ConfigurationEntityManipulatorTrait;

class DefaultConfigurationNormalizer extends AbstractEntityNormalizer
{
    use ConfigurationEntityManipulatorTrait;

    public function normalizeEntity(
        Configuration|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return ConfigurationDto::fromEntity($entity);
    }
}
