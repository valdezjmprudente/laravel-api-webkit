<?php

namespace App\Enums;

/**
 * Enum representing different authentication methods used in the application.
 */
enum AuthenticationType: string
{
    /**
     * Sanctum authentication (uses opaque tokens).
     *
     * @see https://laravel.com/docs/10.x/sanctum#issuing-mobile-api-tokens
     */
    case SANCTUM = 'sanctum';

    /**
     * JSON Web Token authentication.
     *
     * @see https://jwt.io
     */
    case JWT = 'jwt';

    /**
     * API Key authentication.
     */
    case API_KEY = 'api_key';

    /**
     * Get all authentication types as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for authentication types.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::SANCTUM->value => 'Sanctum authentication (token-based)',
            self::JWT->value => 'JWT authentication (stateless authentication)',
            self::API_KEY->value => 'API Key authentication (static keys)',
        ];
    }

    /**
     * Get the description of the current authentication type.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown authentication type';
    }
}
