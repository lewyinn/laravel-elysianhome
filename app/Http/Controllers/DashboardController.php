<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pastikan pengguna sudah login sebelum mencoba mendapatkan data pengguna
        if (Auth::check()) {
            $userRole = Auth::user()->role; // Ambil role user yang sedang login
            return view('be.dashboard.index', [
                'title' => 'Dashboard'
            ], compact('userRole'));
        }

        // Jika pengguna belum login, arahkan ke halaman login atau tampilkan pesan
        return redirect()->route('login')->withErrors(['error' => 'You must be logged in to access this page.']);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
