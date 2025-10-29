<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Exception;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BukuController extends Controller
{
    /**
     * Extract public_id from Cloudinary URL
     */
    private function extractPublicIdFromUrl($url)
    {
        if (!$url) return null;
        
        // Pattern to match Cloudinary URLs and extract public_id
        // Example: https://res.cloudinary.com/dnbsz4cvm/image/upload/v1761771275/book-covers/filename.png
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.(?:jpg|jpeg|png|gif|webp)$/i', $url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

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
            // if ($request->hasFile('cover')) {
            //     $file = $request->file('cover');
                
            //     if ($file->isValid()) {
            //         $uploadPath = public_path('images');
            //         if (!file_exists($uploadPath)) {
            //             mkdir($uploadPath, 0755, true);
            //         }
                    
            //         $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            //         $file->move($uploadPath, $filename);
            //         $validated['cover'] = 'images/' . $filename;
                    
            //         Log::info('File uploaded successfully', [
            //             'filename' => $filename,
            //             'user_id' => auth()->id()
            //         ]);
            //     } else {
            //         Log::error('File upload failed', [
            //             'error' => $file->getError(),
            //             'user_id' => auth()->id()
            //         ]);
            //         return back()->withErrors(['cover' => 'File upload gagal. Silakan coba lagi.'])->withInput();
            //     }
            // }

            $coverPath = null;
            if ($request->hasFile('cover')) {
                try {
                    Log::info('Starting Cloudinary upload', [
                        'file_name' => $request->file('cover')->getClientOriginalName(),
                        'file_size' => $request->file('cover')->getSize(),
                        'user_id' => auth()->id()
                    ]);
                    
                    // Use HTTP client approach like in migration (SSL bypass)
                    $cloudName = config('cloudinary.cloud_name');
                    $apiKey = config('cloudinary.api_key');
                    $apiSecret = config('cloudinary.api_secret');
                    $timestamp = time();
                    $publicId = 'book-covers/book_' . $timestamp . '_' . uniqid();
                    
                    // Generate signature
                    $signature = hash('sha1', "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");
                    
                    $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                        ->asMultipart()
                        ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                            'file' => fopen($request->file('cover')->getRealPath(), 'r'),
                            'public_id' => $publicId,
                            'api_key' => $apiKey,
                            'timestamp' => $timestamp,
                            'signature' => $signature
                        ]);
                    
                    if (!$response->successful()) {
                        throw new Exception('Cloudinary upload failed: ' . $response->body());
                    }
                    
                    $uploadResult = $response->json();
                    
                    $coverPath = $uploadResult['secure_url']; // Get the HTTPS URL
                    
                    Log::info('Cloudinary upload successful', [
                        'cloudinary_url' => $coverPath,
                        'user_id' => auth()->id()
                    ]);
                } catch (Exception $uploadException) {
                    Log::error('Cloudinary upload failed', [
                        'error' => $uploadException->getMessage(),
                        'trace' => $uploadException->getTraceAsString(),
                        'user_id' => auth()->id()
                    ]);
                    return back()->withErrors(['cover' => 'Upload gambar gagal: ' . $uploadException->getMessage()])->withInput();
                }
            }
            
            Log::info('Creating book with data', [
                'judul' => $request->judul,
                'jenis' => $request->jenis,
                'cover_path' => $coverPath,
                'user_id' => auth()->id()
            ]);
            
            $buku = Buku::create([
                'judul' => $request->judul,
                'jenis' => $request->jenis,
                'sinopsis' => $request->sinopsis,
                'cover' => $coverPath, // Store the Cloudinary URL
            ]);
            
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
            try {
                // Delete old image from Cloudinary if exists
                if ($managementbuku->cover) {
                    try {
                        // Extract public_id from Cloudinary URL
                        $publicId = $this->extractPublicIdFromUrl($managementbuku->cover);
                        if ($publicId) {
                            // Use HTTP approach for delete (SSL bypass)
                            $cloudName = config('cloudinary.cloud_name');
                            $apiKey = config('cloudinary.api_key');
                            $apiSecret = config('cloudinary.api_secret');
                            $timestamp = time();
                            
                            $signature = hash('sha1', "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");
                            
                            $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                                ->asForm()
                                ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
                                    'public_id' => $publicId,
                                    'api_key' => $apiKey,
                                    'timestamp' => $timestamp,
                                    'signature' => $signature
                                ]);
                            Log::info('Old image deleted from Cloudinary', [
                                'public_id' => $publicId,
                                'user_id' => auth()->id()
                            ]);
                        }
                    } catch (Exception $e) {
                        Log::warning('Failed to delete old image from Cloudinary', [
                            'error' => $e->getMessage(),
                            'cover_url' => $managementbuku->cover
                        ]);
                    }
                }

                // Upload new image to Cloudinary
                Log::info('Starting Cloudinary upload for update', [
                    'book_id' => $managementbuku->id,
                    'user_id' => auth()->id()
                ]);
                
                // Use HTTP client approach like in migration (SSL bypass)
                $cloudName = config('cloudinary.cloud_name');
                $apiKey = config('cloudinary.api_key');
                $apiSecret = config('cloudinary.api_secret');
                $timestamp = time();
                $publicId = 'book-covers/book_' . $timestamp . '_' . uniqid();
                
                // Generate signature
                $signature = hash('sha1', "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");
                
                $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                    ->asMultipart()
                    ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                        'file' => fopen($request->file('cover')->getRealPath(), 'r'),
                        'public_id' => $publicId,
                        'api_key' => $apiKey,
                        'timestamp' => $timestamp,
                        'signature' => $signature
                    ]);
                
                if (!$response->successful()) {
                    throw new Exception('Cloudinary upload failed: ' . $response->body());
                }
                
                $uploadResult = $response->json();
                
                $validated['cover'] = $uploadResult['secure_url'];
                
                Log::info('Update upload successful', [
                    'new_cover_url' => $validated['cover'],
                    'user_id' => auth()->id()
                ]);
            } catch (Exception $uploadException) {
                Log::error('Update upload failed', [
                    'error' => $uploadException->getMessage(),
                    'trace' => $uploadException->getTraceAsString(),
                    'user_id' => auth()->id()
                ]);
                return back()->withErrors(['cover' => 'Upload gambar gagal: ' . $uploadException->getMessage()])->withInput();
            }
        }

        Log::info('Updating book with validated data', [
            'book_id' => $managementbuku->id,
            'validated_data' => $validated,
            'user_id' => auth()->id()
        ]);

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

        // Delete image from Cloudinary if exists
        if ($managementbuku->cover) {
            try {
                // Extract public_id from Cloudinary URL
                $publicId = $this->extractPublicIdFromUrl($managementbuku->cover);
                if ($publicId) {
                    // Use HTTP approach for delete (SSL bypass)
                    $cloudName = config('cloudinary.cloud_name');
                    $apiKey = config('cloudinary.api_key');
                    $apiSecret = config('cloudinary.api_secret');
                    $timestamp = time();
                    
                    $signature = hash('sha1', "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");
                    
                    $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                        ->asForm()
                        ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
                            'public_id' => $publicId,
                            'api_key' => $apiKey,
                            'timestamp' => $timestamp,
                            'signature' => $signature
                        ]);
                }
            } catch (Exception $e) {
                Log::warning('Failed to delete image from Cloudinary', [
                    'error' => $e->getMessage(),
                    'cover_url' => $managementbuku->cover
                ]);
            }
        }

        $managementbuku->delete();

        return redirect()->route('managementbuku.index')
                       ->with('success', 'Buku berhasil dihapus!');
    }
}