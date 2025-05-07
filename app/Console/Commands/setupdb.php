<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class setupdb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setupdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->call('migrate:fresh');
        $this->info('Database setup complete!');
    }
}
