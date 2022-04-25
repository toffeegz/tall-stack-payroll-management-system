<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScheduleWorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Started';

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
        $this->info('Schedule worker started successfully.');

        while (true) {
            if (now()->second === 0) {
                $this->call('schedule:run');
            }

            sleep(1);
        }
    }
}
