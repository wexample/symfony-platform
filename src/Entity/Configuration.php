<?php

namespace Wexample\SymfonyPlatform\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Wexample\Pseudocode\Attribute\PseudocodeExport;
use Wexample\SymfonyApi\Attribute\ApiEntity;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyPlatform\Repository\ConfigurationRepository;

/**
 * A value the app remembers under a key: an account token, a menu left closed.
 *
 * Read from a record like everything else — `<uuid>.yml` — so the key is a field
 * inside it and never the file name: what a record is called says its identity
 * and nothing more. Two records may then claim the same key, and whoever writes
 * them answers for that.
 *
 * The value is stored as JSON because a configuration is rarely a string for
 * long: a list of hosts, a size, a flag. What it means is the reader's business.
 */
#[ApiEntity]
#[PseudocodeExport(inherited: true)]
#[ORM\Entity(repositoryClass: ConfigurationRepository::class)]
#[ORM\Table(name: 'configuration')]
class Configuration extends AbstractEntity
{
    /** The record the value is read from, which is what says the app it belongs to. */
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    protected string $path;

    /** What the value is looked up by: `claude.token`, `ui.menu.collapsed`. */
    #[ORM\Column(type: Types::STRING, length: 128)]
    protected string $key;

    #[ORM\Column(type: Types::JSON, nullable: true, options: ['jsonb' => true])]
    protected mixed $value = null;

    /**
     * Whether the front is handed this one on page load rather than asking for
     * it: a menu state is read on every page, a token is read by nobody there.
     */
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $preload = false;

    public function __construct(string $path)
    {
        parent::__construct();

        $this->path = $path;

        $this->setId(self::idFor($path));
    }

    /** The identity the record is named by, read straight off the file name. */
    public static function idFor(string $path): Uuid
    {
        return Uuid::fromString(pathinfo($path, PATHINFO_FILENAME));
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function isPreload(): bool
    {
        return $this->preload;
    }

    public function setPreload(bool $preload): self
    {
        $this->preload = $preload;

        return $this;
    }
}
