<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManufacturerController extends Controller
{
    public function index() {
        return Inertia::render('Owner/Manufacturer/Index');
    }

    public function create() {
        return Inertia::render('Owner/Manufacturer/Create');
    }
}
