<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response|ResponseFactory
    {
        return inertia('Client/Dashboard/Index');
    }
}
