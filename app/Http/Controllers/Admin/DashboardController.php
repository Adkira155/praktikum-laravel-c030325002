<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return "Halaman Dashboard Admin (Dikelola oleh Admin\\DashboardController di sub-folder Admin)";
    }
}