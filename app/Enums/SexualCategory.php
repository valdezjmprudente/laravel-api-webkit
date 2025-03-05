<?php

namespace App\Enums;

/**
 * Enum representing biological sexual categories.
 */
enum SexualCategory: string
{
    /** Male category */
    case MALE = 'male';

    /** Female category */
    case FEMALE = 'female';

    /**
     * Get all sexual category values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each category.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::MALE->value => 'Male',
            self::FEMALE->value => 'Female',
        ];
    }

    /**
     * Get a description of the current category.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown';
    }
}
