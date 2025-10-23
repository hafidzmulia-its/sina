<?php


namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class BukuUserController extends Controller
{
    public function index(Request $request): View
    {
        $query = Buku::query();

        // Filter by jenis (type)
        if ($request->filled('jenis')) {
            $query->byJenis($request->jenis);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sort options
        $sortBy = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->sortBy($sortBy, $direction);

        // Handle per_page parameter
        $perPage = $request->get('per_page', 10);
        
        if ($perPage === 'all') {
            // Get all results without pagination
            $allBooks = $query->get();
            // Create a manual paginator-like object for consistent interface
            $bukus = new \Illuminate\Pagination\LengthAwarePaginator(
                $allBooks, // items
                $allBooks->count(), // total
                $allBooks->count(), // per page (same as total)
                1, // current page
                [
                    'path' => request()->url(),
                    'pageName' => 'page',
                ]
            );
            $bukus->withQueryString();
        } else {
            // Normal pagination
            $perPage = is_numeric($perPage) ? (int) $perPage : 10;
            $perPage = in_array($perPage, [10, 20, 50]) ? $perPage : 10;
            $bukus = $query->paginate($perPage)->withQueryString();
        }

        // Get all available book types for filter
        $jenisOptions = collect(['Fabel', 'Cerita Rakyat', 'Dongeng']);

        return view('buku.index', compact('bukus', 'jenisOptions'));
    }

    public function show(Buku $buku): View
    {
        $user = auth()->user();
        
        // Get or create user's reading history for this book
        $history = History::firstOrCreate(
            [
                'user_username' => $user->username,
                'buku_id' => $buku->id,
            ],
            [
                'progress' => 0,
                'target' => 10, // Everyone has target of 10
                'tanggal_record' => now(),
            ]
        );

        // Get related books (same jenis)
        $relatedBooks = Buku::where('jenis', $buku->jenis)
            ->where('id', '!=', $buku->id)
            ->take(6)
            ->get();

        return view('buku.show', compact('buku', 'relatedBooks', 'history'));
    }

    // Method to handle reading progress
    public function startReading(Buku $buku): RedirectResponse
    {
        $user = auth()->user();
        
        // Get or create history record
        $history = History::firstOrCreate(
            [
                'user_username' => $user->username,
                'buku_id' => $buku->id,
            ],
            [
                'progress' => 0,
                'target' => 10,
                'tanggal_record' => now(),
            ]
        );

        // Increment progress by 1, but don't exceed target
        if ($history->progress < $history->target) {
            $history->progress += 1;
            $history->tanggal_record = now(); // Update last read date
            $history->save();

            $message = "Progress membaca bertambah! ({$history->progress}/{$history->target})";
            
            if ($history->isCompleted()) {
                $message .= " Selamat! Anda telah menyelesaikan buku ini! 🎉";
            }
        } else {
            $message = "Anda sudah menyelesaikan buku ini!";
        }

        return redirect()->back()->with('success', $message);
    }

    // Get books by type (for AJAX calls)
    public function byType(Request $request, string $jenis)
    {
        $bukus = Buku::byJenis($jenis)
            ->when($request->filled('search'), function($query) use ($request) {
                $query->search($request->search);
            })
            ->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'data' => $bukus->items(),
                'pagination' => [
                    'current_page' => $bukus->currentPage(),
                    'last_page' => $bukus->lastPage(),
                    'per_page' => $bukus->perPage(),
                    'total' => $bukus->total()
                ]
            ]);
        }

        $jenisOptions = collect(['Fabel', 'Cerita Rakyat', 'Dongeng']);
        return view('buku.index', compact('bukus', 'jenisOptions'));
    }
}