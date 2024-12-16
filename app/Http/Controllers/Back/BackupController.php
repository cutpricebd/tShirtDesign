<?php

namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use mysqli;
use ZanySoft\Zip\Zip;

class BackupController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     */
    public function __construct()
    {
        //
    }


    public function systemBackup()
    {
        set_time_limit(30000);
        ini_set('memory_limit','-1');
        $dir = public_path();

        $zip_file = 'backup-esa-'.Carbon::now().'.zip';

        // Get real path for our folder
        $rootPath = realpath($dir);

        $zip = (new \ZanySoft\Zip\Zip)->create($zip_file)->add($rootPath, true);
        $zip->close();


        header('Content-disposition: attachment; filename='.$zip_file);
        header('Content-type: application/zip');
        readfile($zip_file);
        @unlink($zip_file);
    }

    public function databaseBackup()
    {
        set_time_limit(30000);
        ini_set('memory_limit','-1');

        $filename = "backup-" . \Illuminate\Support\Carbon::now()->format('Y-m-d') . ".sql";
        if (!Storage::exists('/backup/')){
            Storage::makeDirectory('/backup/');
        }
        $file_name = storage_path() . "/app/backup/" . $filename;
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . $file_name;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        flush();
        readfile($file_name);
        unlink($file_name);
    }
}
