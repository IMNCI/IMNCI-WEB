<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DriveBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drivebackup:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database to drive';

    protected $scope;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->scope = implode(' ', array(\Google_Service_Drive::DRIVE_METADATA_READONLY));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $content = \Storage::disk('local')->get(('backups/homestead_20180224032045.sql'));
        echo $size . "\n";die;
        
    }

    
}
