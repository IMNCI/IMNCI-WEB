<?php

namespace App\Listeners;

use App\Events\UploadBackupDrive;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadDriveComplete
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
     * @param  UploadBackupDrive  $event
     * @return void
     */
    public function handle(UploadBackupDrive $event)
    {
        $client = \GoogleDrive::getClient();
        $service = new \Google_Service_Drive($client);
        $file = $event->file;
        $fileMetadata = new \Google_Service_Drive_DriveFile(array('name' => $file->getRelativePathName()));
        $content = $file->getContents();

        $file = $service->files->create($fileMetadata, [
            'data'          =>  $content,
            'uploadType'    =>  'multipart',
            'fields'        =>  'id'
        ]);
    }
}
