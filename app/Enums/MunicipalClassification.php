<?php

namespace App\Enums;

/**
 * Enum representing municipal classifications.
 */
enum MunicipalClassification: string
{
    /** A city classification */
    case CITY = 'city';

    /** A municipality classification */
    case MUNICIPALITY = 'municipality';

    /**
     * Get all municipal classification values as an array.
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
            self::CITY->value => 'City - A highly urbanized or component city.',
            self::MUNICIPALITY->value => 'Municipality - A local government unit smaller than a city.',
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
