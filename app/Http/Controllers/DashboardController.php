<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function index()
     {
        if (!Auth::check()) {
            abort(403, 'Akses ditolak');
        }

        if (in_array(Auth::user()->roles, ['ADMIN', 'STAFF'])) {
            // lanjut ke dashboard
        } else {
            Auth::logout();
            abort(403, 'Akses ditolak');
        }
        return view('pages.dashboard');
    }
}
