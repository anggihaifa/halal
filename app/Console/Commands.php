<?php
namespace App\Console\Commands;

use App\Imports\TanahBangunanImport;
use Illuminate\Console\Command;

class ImportExcel extends Command
{
    protected $signature = 'import:excel';

    protected $description = 'Laravel Excel importer';

    protected $file;

    public function __construct($file)
    {
        $this->file = $file;

    }

    public function handle()
    {
        $this->output->title('Starting import');
        (new TanahBangunanImport)->withOutput($this->output)->import($this->file);
        $this->output->success('Import successful');
    }
}