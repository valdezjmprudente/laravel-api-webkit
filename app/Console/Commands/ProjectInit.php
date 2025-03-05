<?php

namespace App\Console\Commands;

use App\Enums\AppEnvironment;
use Illuminate\Console\Command;
use Throwable;

class ProjectInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init {--force : Skip confirmation prompts and run in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the project. Generates app key, runs migrations, seeders, and more.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->title("\u{1F680} Project Initialization Started...");

        $env = app()->environment();

        // Ensure safe execution in production
        if ($env === AppEnvironment::PRODUCTION->value && ! $this->option('force')) {
            $this->error("\u{1F6A8} WARNING: You are in PRODUCTION!");
            if (! $this->confirm('Are you sure you want to continue? This may reset your database.', false)) {
                $this->warn("\u{1F6D1} Operation aborted.");

                return Command::FAILURE;
            }
        }

        // Steps Execution
        $this->executeStep('Generating Application Key', fn () => $this->call('key:generate'));
        $this->executeStep('Refreshing Database', fn () => $this->call('migrate:refresh'));
        $this->executeStep('Seeding Database', fn () => $this->call('db:seed'));

        // Run Code Styler in Local Environment
        if ($env === AppEnvironment::LOCAL->value) {
            $this->executeStep('Running Code Styler', fn () => $this->call('app:styler', ['--ide_helper' => true]));
        }

        $this->info("\u{1F389} Project Initialization Completed Successfully!");

        return Command::SUCCESS;
    }

    /**
     * Execute a step with timing and error handling.
     */
    private function executeStep(string $description, callable $task): void
    {
        $this->line("\u{1F4DD} $description...");

        $startTime = microtime(true);
        try {
            $task();
            $duration = round(microtime(true) - $startTime, 2);
            $this->info("\u{2705} Done! ($duration seconds)");
        } catch (Throwable $e) {
            $this->error("\u{274C} Failed: ".$e->getMessage());
        }
    }

    /**
     * Display a title with formatting.
     */
    private function title(string $message): void
    {
        $this->line("\n========================================");
        $this->info($message);
        $this->line("========================================\n");
    }
}
