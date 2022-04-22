<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\ImportCarsCsvReport;
use App\Actions\ImportCarsCsvAction;
use Illuminate\Support\Facades\Mail;

class ImportCarsCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stoneacre:import-cars-csv {filename? : The filename of the csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cars from a csv file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        public ImportCarsCsvAction $importCarsCsvAction
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $filename = $this->argument('filename') ?? 'example_stock.csv';

        $report = $this->importCarsCsvAction->execute("csv/{$filename}");

        Mail::to('hello@example.com')
            ->send(new ImportCarsCsvReport($report));
    }
}
