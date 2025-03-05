<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Abstract class providing idempotent, CI/CD-compliant database seeding.
 * Ensures seeders can run multiple times without introducing duplicates or
 * breaking database integrity.
 */
abstract class CiCdCompliantSeeder extends Seeder
{
    /**
     * Determines whether the seeder should run based on its idempotence.
     *
     * @return bool True if the seeder guarantees idempotence and can be safely re-run.
     */
    abstract public function shouldRun(): bool;

    /**
     * Returns the database table name this seeder targets.
     *
     * @return string The table name.
     */
    abstract protected function tableName(): string;

    /**
     * The actual seeding logic. Must be implemented by child classes.
     */
    abstract public function run(): void;

    /**
     * Checks if the target table is empty.
     *
     * @param  string  $pkName  The primary key column name (defaults to 'id').
     * @return bool True if the table has no records, false otherwise.
     */
    protected function tableIsEmpty(string $pkName = 'id'): bool
    {
        $tableName = $this->tableName();
        $count = DB::table($tableName)->count($pkName);

        if ($count > 0) {
            Log::info("🚀 [Seeder Skipped] {$tableName} already has records.");
        } else {
            Log::info("✅ [Seeder Allowed] {$tableName} is empty. Seeding...");
        }

        return $count === 0;
    }

    /**
     * Checks if the specified records do not exist in the table.
     *
     * @param  string  $column  The column to check.
     * @param  array  $records  The values to check for in the column.
     * @return bool True if none of the specified records exist, false otherwise.
     */
    protected function recordsNotInTable(string $column, array $records): bool
    {
        $tableName = $this->tableName();
        $existingCount = DB::table($tableName)->whereIn($column, $records)->count();

        if ($existingCount > 0) {
            Log::info("🚀 [Seeder Skipped] Some records already exist in {$tableName}.");
            return false;
        }

        Log::info("✅ [Seeder Allowed] No matching records found in {$tableName}. Seeding...");
        return true;
    }

    /**
     * Executes the seeder safely with database transactions.
     *
     * @return void
     */
    public function safeRun(): void
    {
        if (! $this->shouldRun()) {
            Log::info("⚠️ [Seeder Skipped] " . static::class . " marked as non-idempotent.");
            return;
        }

        DB::beginTransaction();

        try {
            $this->run();
            DB::commit();
            Log::info("✅ [Seeder Completed] " . static::class . " executed successfully.");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("❌ [Seeder Failed] " . static::class . ": " . $e->getMessage());
            $this->command->error('❌ Seeder failed: ' . $e->getMessage());
        }
    }
}
