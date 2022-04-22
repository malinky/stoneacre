<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Services\CsvImportReport;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportCarsCsvReport extends Mailable
{
    use SerializesModels;

    public CsvImportReport $report;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CsvImportReport $report)
    {
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.import-cars-csv-report');
    }
}
