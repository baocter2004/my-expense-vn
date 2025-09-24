<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show() 
    {
        
    }

    public function showFormChangePassword() 
    {
        return view('admin.pages.profile.change-password');
    }
}
