<?php

namespace App\Enums;

/**
 * Enum representing different user roles within the application.
 */
enum Role: string
{
    /** Standard user with limited access */
    case STANDARD_USER = 'standard_user';

    /** Administrator with elevated privileges */
    case ADMIN = 'admin';

    /** System support role for troubleshooting */
    case SYSTEM_SUPPORT = 'system_support';

    /** Super user with the highest level of access */
    case SUPER_USER = 'super_user';

    /**
     * Get all role values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each role.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::STANDARD_USER->value => 'Standard user with limited access.',
            self::ADMIN->value => 'Administrator with elevated privileges.',
            self::SYSTEM_SUPPORT->value => 'System support role for troubleshooting.',
            self::SUPER_USER->value => 'Super user with the highest level of access.',
        ];
    }

    /**
     * Get a description of the current role.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown role';
    }

    /**
     * Determine if the role has administrative privileges.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array($this, [self::ADMIN, self::SUPER_USER], true);
    }
}
