<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Actions\ExportCarsCsvAction;
use Illuminate\Support\Facades\Storage;

class ExportCarsCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stoneacre:export-cars-csv {make? : The make of the car}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export cars to a csv file by make.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        public ExportCarsCsvAction $exportCarsCsvAction
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $make = $this->argument('make') ?? 'Ford';

        $path = $this->exportCarsCsvAction->execute($make);

        $file = Storage::disk('public')->get($path);

        Storage::disk('ftp')->put($path, $file);
    }
}
