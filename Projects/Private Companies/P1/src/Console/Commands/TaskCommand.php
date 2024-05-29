<?php

namespace AliSalehi\Task\Console\Commands;

use Illuminate\Console\Command;
use AliSalehi\Task\Jobs\SendTaskDueJob;

class TaskCommand extends Command
{
    protected $signature = 'schedule:tasks';
    protected $description = 'Schedule tasks due within the next 24 hours';
    
    public function handle()
    {
        SendTaskDueJob::dispatch();
        $this->info('Scheduled tasks due within the next 24 hours.');
    }
}
