<?php

namespace App\Enums;

/**
 * Enum representing user permissions in the system.
 */
enum Permission: string
{
    /** View user profiles */
    case VIEW_PROFILE = 'view_profile';

    /** Update user profile details */
    case UPDATE_PROFILE = 'update_profile';

    /** Create new user accounts */
    case CREATE_USERS = 'create_users';

    /** View a list of users */
    case VIEW_USERS = 'view_users';

    /** Update user account information */
    case UPDATE_USERS = 'update_users';

    /** Delete user accounts */
    case DELETE_USERS = 'delete_users';

    /** Receive system alerts and notifications */
    case RECEIVE_SYSTEM_ALERTS = 'receive_system_alerts';

    /** View assigned roles of users */
    case VIEW_USER_ROLES = 'view_user_roles';

    /** View available permissions */
    case VIEW_PERMISSIONS = 'view_permissions';

    /** Modify application settings */
    case UPDATE_APP_SETTINGS = 'update_app_settings';

    /**
     * Get all permission values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each permission.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::VIEW_PROFILE->value => 'Allows viewing user profile details.',
            self::UPDATE_PROFILE->value => 'Allows updating user profile information.',
            self::CREATE_USERS->value => 'Allows creation of new users in the system.',
            self::VIEW_USERS->value => 'Allows viewing a list of all users.',
            self::UPDATE_USERS->value => 'Allows modifying user details.',
            self::DELETE_USERS->value => 'Allows deleting user accounts.',
            self::RECEIVE_SYSTEM_ALERTS->value => 'Allows receiving critical system alerts.',
            self::VIEW_USER_ROLES->value => 'Allows viewing assigned roles of users.',
            self::VIEW_PERMISSIONS->value => 'Allows viewing available permissions.',
            self::UPDATE_APP_SETTINGS->value => 'Allows modifying application settings.',
        ];
    }

    /**
     * Get a description of the current permission.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown permission.';
    }
}
