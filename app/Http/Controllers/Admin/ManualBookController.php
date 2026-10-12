<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualBookController extends Controller
{
    /**
     * Display the comprehensive interactive Manual Book inside Admin Panel.
     */
    public function index()
    {
        return view('admin.manual-book.index');
    }
}
