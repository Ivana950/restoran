<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;


class MeniController extends Controller
{
    public function index()
    {
        return view('user.meni');
    }
}
