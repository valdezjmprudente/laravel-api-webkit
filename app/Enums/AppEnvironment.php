<?php

namespace App\Enums;

/**
 * Application environment definitions.
 */
enum AppEnvironment: string
{
    case PRODUCTION = 'production';
    case UAT = 'uat';
    case DEVELOPMENT = 'development';
    case LOCAL = 'local';
    case TESTING = 'testing';

    /**
     * Get all environment values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the current application environment.
     *
     * @return self|null
     */
    public static function current(): ?self
    {
        return self::tryFrom(app()->environment());
    }

    /**
     * Check if the current environment is production.
     *
     * @return bool
     */
    public static function isProduction(): bool
    {
        return self::current() === self::PRODUCTION;
    }
}
