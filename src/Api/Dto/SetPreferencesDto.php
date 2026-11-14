<?php

namespace Wexample\SymfonyPlatform\Api\Dto;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Wexample\SymfonyApi\Api\Attribute\RequiredDtoProperty;
use Wexample\SymfonyApi\Api\Dto\AbstractDto;
use Wexample\SymfonyHelpers\Helper\VariableHelper;

/**
 * Preferences written together — a theme setting its axes at once —, keyed as
 * they are kept, a null value forgetting its key. Who they belong to is never
 * sent: it is the visitor's, or everybody's, as the app chose.
 */
class SetPreferencesDto extends AbstractDto
{
    /**
     * Far more than a page writes at once: what is sent beyond is no visitor's
     * choice, and each key is a row.
     */
    final public const int MAX_VALUES = 100;

    /**
     * The length of the column keeping a key (symfony-preference's Preference).
     */
    final public const int MAX_KEY_LENGTH = 255;

    /** @var array<string, mixed> */
    #[Type(VariableHelper::VARIABLE_TYPE_ARRAY)]
    #[Count(max: self::MAX_VALUES)]
    #[RequiredDtoProperty]
    public array $values = [];

    /**
     * A key the column cannot hold is refused here, as the caller's mistake,
     * rather than by the database as a failure of the server.
     */
    #[Callback]
    public function validateKeys(ExecutionContextInterface $context): void
    {
        foreach (array_keys($this->values) as $key) {
            $key = (string) $key;

            if (mb_strlen($key) > self::MAX_KEY_LENGTH) {
                $context->buildViolation('A preference key is at most {{ max }} characters long.')
                    ->setParameter('{{ max }}', (string) self::MAX_KEY_LENGTH)
                    ->atPath('values')
                    ->setInvalidValue($key)
                    ->addViolation();
            }
        }
    }
}
