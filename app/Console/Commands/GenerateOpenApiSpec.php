<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateOpenApiSpec extends Command
{
    // The name of the command (used in `php artisan`).
    protected $signature = 'openapi:generate
                            {--o|output= : The output file name (default: openapi.yaml)}';

    // The description of the command.
    protected $description = 'Generate the OpenAPI specification file.';

    public function handle()
    {
        $outputFile = $this->option('output') ?? 'openapi.yaml';

        // Run the OpenAPI generation command.
        $command = "php vendor/bin/openapi app -o {$outputFile}";

        $this->info("Running OpenAPI generator...");

        // Execute the shell command.
        $process = shell_exec($command);

        if ($process === null) {
            $this->error('Failed to run the OpenAPI generator.');
        } else {
            $this->info("OpenAPI spec generated at: {$outputFile}");
        }
    }
}

