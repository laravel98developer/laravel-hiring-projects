<?php

namespace App\Console\Commands\FetchData;

use App\Services\Providers\HeavenlyProvider;
use App\Services\Providers\MajestyProvider;
use Illuminate\Console\Command;

class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'get products from providers and save it';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $providers = [
          'heavenly' => HeavenlyProvider::class,
          'majesty' => MajestyProvider::class,
        ];

        $this->info('start fetching products ...');
        $bar = $this->output->createProgressBar(count($providers));
        $bar->start();
        $this->newLine();

        foreach ($providers as $key => $value){
            $this->info("fetching from {$key}...");
            ${$key} = new $value;
            ${$key}->getTours();
            ${$key}->getActivities();
            ${$key}->getEvents();
            $this->info("fetched successfully");
            $bar->advance();
            $this->newLine();
        }

        $this->info('products fetched successfully');
        $bar->finish();
        return Command::SUCCESS;
    }
}
