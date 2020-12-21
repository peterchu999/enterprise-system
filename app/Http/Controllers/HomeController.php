<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Mail\BackupMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('FAQ');
    }

    public function FAQ(){
        return view('FAQ');
    }

    public function first() {
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
        return redirect()->route('FAQ');
    }
}
