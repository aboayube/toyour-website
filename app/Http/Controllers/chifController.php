<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class chifController extends Controller
{
    //
    public function index()
    {
        $chefs = User::orderBy('id', 'desc')->where('role', 'chef')->where('status', "1")->paginate(10);


        return view('chifs', compact('chefs'));
    }
}
