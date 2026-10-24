<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SapaController extends Controller
{
    public function index()
    {
        $nama = 'Adinda Ridha Salsabila';
        return "Halo, {$nama}! Ini ditulis di dalam Controller.";
    }
}