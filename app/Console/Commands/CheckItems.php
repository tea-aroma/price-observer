<?php

namespace App\Console\Commands;

use App\Standards\Observers\Classes\Observer;
use Illuminate\Console\Command;

class CheckItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'observer:check-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks items';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try
        {
            (new Observer())->check();
        }
        catch(\Exception $e)
        {
            $this->error($e->getMessage());
        }

        return self::SUCCESS;
    }
}
