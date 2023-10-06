<?php

namespace App\Console\Commands;
 
use App\Jobs\TestJob;
use Illuminate\Console\Command;

class DispatchTestJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'dispatch:test-job';

    protected $description = 'Dispatch a test job';

    public function handle()
    {

        dispatch(new TestJob());

        $this->info('Test job dispatched.');
    }
}
