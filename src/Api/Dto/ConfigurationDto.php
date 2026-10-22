<?php

namespace Wexample\SymfonyPlatform\Api\Dto;

use Wexample\SymfonyApi\Api\Dto\AbstractEntityDto;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyPlatform\Entity\Configuration;

class ConfigurationDto extends AbstractEntityDto
{
    public string $path;

    public string $key;

    public mixed $value;

    public bool $preload;

    /**
     * @param Configuration $entity
     */
    public static function fromEntity(AbstractEntity $entity): self
    {
        $dto = parent::fromEntity($entity);

        $dto->path = $entity->getPath();
        $dto->key = $entity->getKey();
        $dto->value = $entity->getValue();
        $dto->preload = $entity->isPreload();

        return $dto;
    }
}
