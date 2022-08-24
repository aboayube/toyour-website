<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contactus;
use App\Models\Rating;
use App\Models\RatingReseservations;
use App\Models\Reservation;
use App\Models\Servce_user;
use App\Models\Servces;
use App\Models\User;
use App\Models\Wasfa;
use App\Models\WasfaUser;
use Illuminate\Http\Request;

class DashboradController extends Controller
{

    public function index()
    {
        $data = [];
        $data['user'] = User::where("role", 'user')->count();
        $data['chef'] = User::where("role", 'chef')->count();
        $data['admin'] = User::where("role", 'admin')->count();
        $data['category'] = Category::where('status', '1')->count();
        $data['wasfas'] = Wasfa::where('status', '1')->count();
        $data['Servces'] = Servces::where('status', "1")->count();
        $data['Reservation'] = Reservation::where('status', '1')->count();
        $data['RatingReseservations'] = RatingReseservations::count();
        $data['Rating'] = Rating::count();
        $data['Servce_user'] = Servce_user::count();
        $data['WasfaUser'] = WasfaUser::where('status', "1")->count();
        $data['Contactus'] = Contactus::count();
        //  dd($data);
        return view('admin.dashborad', compact('data'));
    }
    //
}
