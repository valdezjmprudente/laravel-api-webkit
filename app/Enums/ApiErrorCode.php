<?php

namespace App\Enums;

/**
 * Enum representing API error codes returned to clients.
 */
enum ApiErrorCode: string
{
    /** Validation failed */
    case VALIDATION = 'VALIDATION_ERROR';

    /** The requested resource was not found */
    case RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND_ERROR';

    /** The provided credentials are incorrect */
    case INVALID_CREDENTIALS = 'INVALID_CREDENTIALS_ERROR';

    /** SMTP-related error occurred */
    case SMTP_ERROR = 'SMTP_ERROR';

    /** Unauthorized access attempt */
    case UNAUTHORIZED = 'UNAUTHORIZED_ERROR';

    /** Access forbidden due to insufficient permissions */
    case FORBIDDEN = 'FORBIDDEN_ERROR';

    /** The requested route does not exist */
    case UNKNOWN_ROUTE = 'UNKNOWN_ROUTE_ERROR';

    /** Too many requests, rate limit exceeded */
    case RATE_LIMIT = 'TOO_MANY_REQUESTS_ERROR';

    /** A dependency service failed */
    case DEPENDENCY_ERROR = 'DEPENDENCY_ERROR';

    /** Internal server error */
    case SERVER = 'SERVER_ERROR';

    /** Incorrect old password provided */
    case INCORRECT_OLD_PASSWORD = 'INCORRECT_OLD_PASSWORD_ERROR';

    /** Request payload exceeds the allowed limit */
    case PAYLOAD_TOO_LARGE = 'PAYLOAD_TOO_LARGE_ERROR';

    /** Email address has not been verified */
    case EMAIL_NOT_VERIFIED = 'EMAIL_NOT_VERIFIED_ERROR';

    /** Bad request due to invalid parameters */
    case BAD_REQUEST = 'BAD_REQUEST_ERROR';

    /** Webhooks are disabled for this request */
    case WEBHOOKS_DISABLED = 'WEBHOOKS_DISABLED';

    /** Invalid multi-factor authentication attempt token */
    case INVALID_MFA_ATTEMPT_TOKEN = 'INVALID_MFA_ATTEMPT_TOKEN_ERROR';

    /** Invalid multi-factor authentication code */
    case INVALID_MFA_CODE = 'INVALID_MFA_CODE_ERROR';

    /** Invalid multi-factor authentication backup code */
    case INVALID_MFA_BACKUP_CODE = 'INVALID_MFA_BACKUP_CODE_ERROR';

    /**
     * Get all API error codes as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each error code.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::VALIDATION->value => 'Validation failed due to incorrect input.',
            self::RESOURCE_NOT_FOUND->value => 'The requested resource was not found.',
            self::INVALID_CREDENTIALS->value => 'Invalid username or password.',
            self::SMTP_ERROR->value => 'SMTP server error occurred while sending email.',
            self::UNAUTHORIZED->value => 'User authentication required.',
            self::FORBIDDEN->value => 'You do not have permission to access this resource.',
            self::UNKNOWN_ROUTE->value => 'The requested route does not exist.',
            self::RATE_LIMIT->value => 'Too many requests. Please try again later.',
            self::DEPENDENCY_ERROR->value => 'A dependent service encountered an error.',
            self::SERVER->value => 'An internal server error occurred.',
            self::INCORRECT_OLD_PASSWORD->value => 'The old password provided is incorrect.',
            self::PAYLOAD_TOO_LARGE->value => 'The request payload exceeds the allowed limit.',
            self::EMAIL_NOT_VERIFIED->value => 'Your email has not been verified yet.',
            self::BAD_REQUEST->value => 'Invalid request parameters.',
            self::WEBHOOKS_DISABLED->value => 'Webhooks are currently disabled.',
            self::INVALID_MFA_ATTEMPT_TOKEN->value => 'Invalid MFA attempt token provided.',
            self::INVALID_MFA_CODE->value => 'Invalid MFA verification code entered.',
            self::INVALID_MFA_BACKUP_CODE->value => 'Invalid MFA backup code provided.',
        ];
    }

    /**
     * Get a description of the current error code.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown error.';
    }
}
