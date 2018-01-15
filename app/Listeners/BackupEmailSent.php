<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupEmailSent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $directory = storage_path('app/backups');
        $files = File::allFiles($directory);

        foreach ($files as $file) {
            \File::delete($file->getPathname());
        }
    }
}
