<?php

declare(strict_types=1);

namespace Wexample\SymfonyPlatform\Tests\Unit\Api\Dto;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Wexample\SymfonyPlatform\Api\Dto\SetPreferencesDto;

/**
 * What a client may write at once: no more keys than a page sets, none longer
 * than the column keeping it.
 */
class SetPreferencesDtoTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
    }

    public function testPreferencesAPageWritesAreTaken(): void
    {
        $this->assertCount(0, $this->validate(['ui.color_scheme' => 'dark', 'ui.layout.menu.left' => null]));
        $this->assertCount(0, $this->validate([]));
        $this->assertCount(0, $this->validate([str_repeat('é', SetPreferencesDto::MAX_KEY_LENGTH) => true]));
        $this->assertCount(0, $this->validate(array_fill_keys(array_map(static fn (int $i) => 'k' . $i, range(1, SetPreferencesDto::MAX_VALUES)), 1)));
    }

    public function testAKeyLongerThanItsColumnIsRefused(): void
    {
        $key = 'ui.' . str_repeat('a', SetPreferencesDto::MAX_KEY_LENGTH);
        $violations = $this->validate(['ui.color_scheme' => 'dark', $key => true]);

        $this->assertCount(1, $violations);
        $this->assertSame('values', $violations[0]->getPropertyPath());
        $this->assertSame($key, $violations[0]->getInvalidValue());
    }

    public function testTooManyKeysAreRefused(): void
    {
        $values = array_fill_keys(array_map(static fn (int $i) => 'k' . $i, range(1, SetPreferencesDto::MAX_VALUES + 1)), 1);

        $this->assertCount(1, $this->validate($values));
    }

    private function validate(array $values): ConstraintViolationListInterface
    {
        $dto = new SetPreferencesDto();
        $dto->values = $values;

        return $this->validator->validate($dto);
    }
}
