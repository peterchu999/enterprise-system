<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use ZipArchive;

class AdminController extends Controller
{
    public function index() {
        return view('Admin.index')->with('users',User::all());
    }

    public function destroy($id) {
        $user = User::where('id',$id)->first()->delete();
    }
}
