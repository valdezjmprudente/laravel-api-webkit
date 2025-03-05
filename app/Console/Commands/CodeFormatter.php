<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Throwable;

class CodeFormatter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:styler
                           {--i|ide_helper : Run style fixer with barryvdh/laravel-ide-helper}
                           {--t|test       : Run the style fixer without changing the files}
                           {--a|add        : Add the formatting changes to Git}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a global code formatter that follows PHP PSR standards';

    /**
     * Execute the console command.
     *
     * @see https://github.com/stechstudio/Laravel-PHP-CS-Fixer
     * @see https://github.com/barryvdh/laravel-ide-helper
     */
    public function handle(): int
    {
        $this->info("\u{1F9F9} Starting code cleanup...");

        // Run Laravel Pint
        $exitCode = $this->runPint();

        // Run Laravel IDE Helper if requested
        if ($this->option('ide_helper')) {
            $this->runIDEHelper();
        }

        // Add changes to Git if everything succeeded
        if ($exitCode === Command::SUCCESS && ! $this->option('test') && $this->option('add')) {
            $this->runGitAdd();
        }

        $this->info("\u{1F9FA} Code cleanup completed!");

        return $exitCode;
    }

    /**
     * Run Laravel Pint for code formatting.
     */
    private function runPint(): int
    {
        $pintTestArg = $this->option('test') ? '--test' : '';
        $pintCommand = base_path("vendor/bin/pint $pintTestArg");

        $this->line("\u{1F58C} Running Pint...");

        return $this->executeCommand($pintCommand);
    }

    /**
     * Run Laravel IDE Helper commands.
     */
    private function runIDEHelper(): void
    {
        $this->line("\u{1F4DD} Generating IDE helper files...");

        $commands = [
            ['cmd' => 'ide-helper:generate', 'args' => []],
            ['cmd' => 'ide-helper:meta', 'args' => []],
            ['cmd' => 'ide-helper:models', 'args' => ['--nowrite' => true]],
        ];

        foreach ($commands as $command) {
            try {
                $this->call($command['cmd'], $command['args']);
            } catch (Throwable $th) {
                $this->error("\u{1F645} Error running {$command['cmd']}: ".$th->getMessage());
            }
        }
    }

    /**
     * Add changes to Git if formatting was successful.
     */
    private function runGitAdd(): void
    {
        $this->line("\u{1F5C3} Adding formatted files to Git...");
        $exitCode = $this->executeCommand('git add .');

        if ($exitCode === Command::SUCCESS) {
            $this->info("\u{1F44D} Files successfully added to Git.");
        } else {
            $this->warn("\u{1F6A7} Git add failed! Check manually.");
        }
    }

    /**
     * Execute a shell command and handle output.
     */
    private function executeCommand(string $command): int
    {
        $output = [];
        $exitCode = Command::SUCCESS;

        exec($command, $output, $exitCode);

        foreach ($output as $message) {
            $this->line($message);
        }

        return $exitCode;
    }
}
