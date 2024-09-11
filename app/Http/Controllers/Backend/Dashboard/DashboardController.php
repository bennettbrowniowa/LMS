<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index(){
        return view('Backend.blank');
    }

    public function dashboard(){

   $data['admins']=User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'admin');
        })->count();
        $data['approved_instractor']=
            User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Instructor');
            $query->where('is_verified', 1);
        })->count();
        $data['pending_instractor']=
        User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Instructor');
            $query->where('is_verified', 0);
        })->count();
        $data['today_instractor']=
        User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Instructor');
            $query->where('is_verified', 0);
            $query->whereDate('created_at', Carbon::now()->toDateString());
        })->count();
        $data['block_instractor']=
        User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Instructor');
            $query->where('is_blocked', 1);

        })->count();
        $data['specialization']=Specialization::count();

        return view('Backend.dashboard',compact('data'));
    }

}
