<?php

namespace App\Enums;

/**
 * Enum representing available application themes.
 */
enum AppTheme: string
{
    /** Light theme */
    case LIGHT = 'light';

    /** Dark theme */
    case DARK = 'dark';

    /**
     * Get all theme values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each theme.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::LIGHT->value => 'Light Theme',
            self::DARK->value => 'Dark Theme',
        ];
    }

    /**
     * Get a description of the current theme.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown Theme';
    }
}
