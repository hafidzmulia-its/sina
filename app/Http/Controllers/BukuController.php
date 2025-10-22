<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Exception;

class BukuController extends Controller
{
   

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Log::info('BukuController@index accessed', [
            'user_id' => auth()->id(),
            'session_id' => session()->getId()
        ]);

        try {
            $search = $request->get('search');
            $jenis = $request->get('jenis');
            
            $bukus = Buku::query()
                ->when($search, function ($query, $search) {
                    return $query->where('judul', 'like', "%{$search}%")
                               ->orWhere('sinopsis', 'like', "%{$search}%");
                })
                ->when($jenis, function ($query, $jenis) {
                    return $query->where('jenis', $jenis);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $jenisOptions = Buku::distinct()->pluck('jenis')->filter();

            return view('managementbuku.index', compact('bukus', 'jenisOptions', 'search', 'jenis'));
            
        } catch (Exception $e) {
            Log::error('Error in BukuController@index', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return view('managementbuku.index', [
                'bukus' => collect()->paginate(10),
                'jenisOptions' => collect(),
                'search' => $search ?? '',
                'jenis' => $jenis ?? ''
            ])->with('error', 'Terjadi kesalahan saat memuat data buku.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('BukuController@create accessed', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role,
            'session_id' => session()->getId()
        ]);

        $jenisOptions = ['Fabel', 'Cerita Rakyat', 'Dongeng', 'Legenda', 'Mitos'];
        return view('managementbuku.create', compact('jenisOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('BukuController@store called', [
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'has_file' => $request->hasFile('cover')
        ]);

        try {
            $validated = $request->validate([
                'judul' => ['required', 'string', 'max:255', 'unique:bukus,judul'],
                'jenis' => ['required', 'string', 'max:100'],
                'sinopsis' => ['required', 'string'],
                'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);

            Log::info('Validation passed', ['user_id' => auth()->id()]);

            // Handle file upload with better error handling
            if ($request->hasFile('cover')) {
                $file = $request->file('cover');
                
                if ($file->isValid()) {
                    $uploadPath = public_path('images');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                    $file->move($uploadPath, $filename);
                    $validated['cover'] = 'images/' . $filename;
                    
                    Log::info('File uploaded successfully', [
                        'filename' => $filename,
                        'user_id' => auth()->id()
                    ]);
                } else {
                    Log::error('File upload failed', [
                        'error' => $file->getError(),
                        'user_id' => auth()->id()
                    ]);
                    return back()->withErrors(['cover' => 'File upload gagal. Silakan coba lagi.'])->withInput();
                }
            }

            $buku = Buku::create($validated);
            Log::info('Buku created successfully', [
                'buku_id' => $buku->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('managementbuku.index')
                           ->with('success', 'Buku berhasil ditambahkan!');
                           
        } catch (Exception $e) {
            Log::error('Error in BukuController@store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    // ... rest of your methods remain the same
    
    public function show(Buku $managementbuku)
    {
        Log::info('BukuController@show accessed', [
            'buku_id' => $managementbuku->id,
            'user_id' => auth()->id()
        ]);
        
        return view('managementbuku.show', compact('managementbuku'));
    }

    public function edit(Buku $managementbuku)
    {
        Log::info('BukuController@edit accessed', [
            'buku_id' => $managementbuku->id,
            'user_id' => auth()->id()
        ]);
        
        $jenisOptions = ['Fabel', 'Cerita Rakyat', 'Dongeng', 'Legenda', 'Mitos'];
        return view('managementbuku.edit', compact('managementbuku', 'jenisOptions'));
    }

    public function update(Request $request, Buku $managementbuku)
    {
        Log::info('BukuController@update called', [
            'buku_id' => $managementbuku->id,
            'user_id' => auth()->id()
        ]);

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255', Rule::unique('bukus')->ignore($managementbuku->id)],
            'jenis' => ['required', 'string', 'max:100'],
            'sinopsis' => ['required', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            if ($managementbuku->cover && file_exists(public_path($managementbuku->cover))) {
                unlink(public_path($managementbuku->cover));
            }

            $file = $request->file('cover');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('images'), $filename);
            $validated['cover'] = 'images/' . $filename;
        }

        $managementbuku->update($validated);

        return redirect()->route('managementbuku.index')
                       ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $managementbuku)
    {
        Log::info('BukuController@destroy called', [
            'buku_id' => $managementbuku->id,
            'user_id' => auth()->id()
        ]);

        if ($managementbuku->cover && file_exists(public_path($managementbuku->cover))) {
            unlink(public_path($managementbuku->cover));
        }

        $managementbuku->delete();

        return redirect()->route('managementbuku.index')
                       ->with('success', 'Buku berhasil dihapus!');
    }
}