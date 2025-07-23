<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return view('dashboard_admin');
            case 'superadmin':
                return view('dashboard_superadmin');
            case 'entreprise':
                return view('dashboard_entreprise');
            default:
                return view('dashboard_etudiant');
        }
    }
} 