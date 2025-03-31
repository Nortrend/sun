<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function index(): ResponseFactory
    {
        return inertia('Admin/Dashboard/Index');
    }
}
