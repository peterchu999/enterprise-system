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
    public function restoreView() {
        $users = User::onlyTrashed()->get();
        return view('Admin.deletedUser')->with('users', $users);
    }

    public function restore($id) {
        $user = User::withTrashed()->find($id);
        $user->deleted_at = null;
        $user->save();
        return redirect()->route('Admin.index');
    }
    public function destroy($id) {
        $user = User::where('id',$id)->first()->delete();
        return redirect()->back();
    }
}
