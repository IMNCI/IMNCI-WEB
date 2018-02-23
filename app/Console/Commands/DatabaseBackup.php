<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\BackEmailJob;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\BackupEmailSent;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DatabaseBackup:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Back up the database daily';

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
     * @return mixed
     */
    public function handle()
    {
        $details = \Artisan::call('backup:mysql-dump');
        $directory = storage_path('app/backups');
        $files = \File::allFiles($directory);
        $files_array = [];
        $dump_attachment = $files[count($files) - 1]->getPathname();
        dispatch(new BackEmailJob($dump_attachment));
        event(new BackupEmailSent());
    }
}
