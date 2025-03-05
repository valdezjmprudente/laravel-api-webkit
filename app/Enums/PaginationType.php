<?php

namespace App\Enums;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * Enum representing different pagination strategies available in Laravel.
 */
enum PaginationType: string
{
    /** Traditional pagination with total count */
    case LENGTH_AWARE = LengthAwarePaginator::class;

    /** Simple pagination without total count */
    case SIMPLE = Paginator::class;

    /** Cursor-based pagination for optimized performance */
    case CURSOR = CursorPaginator::class;

    /**
     * Get all pagination type values as an array.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable descriptions for each pagination type.
     *
     * @return array<string, string>
     */
    public static function descriptions(): array
    {
        return [
            self::LENGTH_AWARE->value => 'Pagination with total result count and multiple pages.',
            self::SIMPLE->value => 'Basic pagination with next/previous links, but no total count.',
            self::CURSOR->value => 'Efficient pagination using database cursors, suitable for large datasets.',
        ];
    }

    /**
     * Get a description of the current pagination type.
     *
     * @return string
     */
    public function description(): string
    {
        return self::descriptions()[$this->value] ?? 'Unknown pagination type.';
    }
}
