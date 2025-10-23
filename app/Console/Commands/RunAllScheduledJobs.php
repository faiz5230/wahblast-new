<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunAllScheduledJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:all-scheduled-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan semua scheduled jobs dalam satu command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('send:scheduled-message');
        Artisan::call('execute:temporary_chats');
        Artisan::call('send:scheduled-group-message');
        Artisan::call('get:message');
        Artisan::call('queue:work --stop-when-empty');
    }
}
