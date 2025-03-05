<?php

namespace App\Enums;

/**
 * Enum representing barangay classifications.
 */
enum BarangayClassification: string
{
    /** Urban barangay classification */
    case URBAN = 'urban';

    /** Rural barangay classification */
    case RURAL = 'rural';

    /**
     * Get all barangay classification values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each classification.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::URBAN->value => 'Urban Barangay - Higher population density with city-like characteristics.',
            self::RURAL->value => 'Rural Barangay - Lower population density with agricultural or countryside characteristics.',
        ];
    }

    /**
     * Get a description of the current classification.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown Classification';
    }
}
