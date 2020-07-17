<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Mail\BackupMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class automate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to automate email sending and optimize cache';

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
        $time = Carbon::now('Asia/Jakarta');
DB::table('backup_counters')->insert(['counter'=>$time]);
        $counter = DB::table('backup_counters')->where('id',1)->first();
		Artisan::call('optimize');
                Artisan::call('route:clear');
                $file = new Filesystem;
                $file->cleanDirectory('storage/app/public');
		dd($file);
                Artisan::call('backup:run --only-db');
                $files = Storage::files('public')[0];
		echo $files;
                
                echo "\n mail have been send ".storage_path('app/WirasuksesBackup')." \n";
                DB::table('backup_counters')->where('id', 1)->update(['counter'=>$time]);
        if ($counter != null) {
            $diff = $time->diffInHours($counter->counter);
            if($diff >= 1){
                
            }
        } else {
            
        } 
        
    }
}
