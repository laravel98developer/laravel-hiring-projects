<?php

namespace AliSalehi\Task\Jobs;

use Illuminate\Bus\Queueable;
use AliSalehi\Task\Models\Task;
use AliSalehi\Task\Models\Relation;
use AliSalehi\Task\Mail\DueTaskMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTaskDueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function handle(): void
    {
        $tasks = Task::where(Task::DUE_DATE, today()->addDay())->where(Task::IS_COMPLETED, Task::$IS_COMPLETED['false'])->get();
        
        foreach ($tasks as $task) {
            Mail::to($task->{Relation::USER}->email)->send(new DueTaskMail());
        }
    }
}
