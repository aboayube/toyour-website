<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wasfa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $wasfas = Wasfa::where('status', "1")->orderBy('id', 'DESC')->take(4)->get();
        $categories = Category::where('status', "1")->take(3)->get();
        $chefs = User::where("role", "chef")->where('status', "1")->orderBy('id', 'DESC')->take(4)->get();

        $chefsOne = User::where("role", "chef")->where('status', "1")->orderBy('id', 'DESC')->first();;

        $chefsTwo = User::where("role", "chef")->where('status', "1")->orderBy('id', 'DESC')->skip(1)->first();;



        $setting = Setting::first();
        return view('welcome', compact('wasfas', 'categories', 'setting', 'chefs', 'chefsOne', 'chefsTwo'));
    }    //
}
