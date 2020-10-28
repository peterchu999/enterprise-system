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
        Artisan::call('optimize');
	    Artisan::call('route:clear');
        $time = Carbon::now('Asia/Jakarta');
        $counter = DB::table('backup_counters')->where('id', 1)->first();
        if ($counter != null) {
            $diff = $time->diffInDays($counter->counter);
            if($diff >= 4){
                $file = new Filesystem;
                $file->cleanDirectory('storage/app/backup');
                Artisan::call('backup:run --only-db');
                $files = Storage::files('backup')[0];
                $files = storage_path().'\\app\\'.$files;
                Mail::to("winston@wirasukses.com")->send(new BackupMail($files, $time->toDateString()));
                Mail::to("peter.andrew987@gmail.com")->send(new BackupMail($files, $time->toDateString()));
                DB::table('backup_counters')->where('id', 1)->update(['counter'=>$time]);
            }
        } else {
            DB::table('backup_counters')->insert(['counter'=>$time]);
        }
    }
}
