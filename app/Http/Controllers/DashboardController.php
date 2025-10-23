<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        // Get user's recent reading history with book details
        $recentHistory = History::with('buku')
            ->byUser($user->username)
            ->latest('tanggal_record')
            ->take(12) // Increased from 6 to 12
            ->get();

        // Get book types with count
        $bookTypes = Buku::selectRaw('jenis, COUNT(*) as count')
            ->groupBy('jenis')
            ->get();

        // Get featured book (for the main jumbotron)
        $featuredBook = Buku::where('judul', 'KURA-KURA & KELINCI')
            ->first() ?? Buku::first();
        // dd($recentHistory);
        // Get popular books
        $popularBooks = Buku::popular()->take(12)->get();

        return view('dashboard', compact(
            'recentHistory', 
            'bookTypes', 
            'featuredBook', 
            'popularBooks'
        ));
    }
}