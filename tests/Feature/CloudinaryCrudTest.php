<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CloudinaryCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a superadmin user for testing
        $this->user = User::factory()->create([
            'role' => 'superadmin',
            'username' => 'testadmin',
            'password' => bcrypt('password')
        ]);
    }

    public function test_book_creation_with_cloudinary_upload()
    {
        // Skip if not in testing environment with actual Cloudinary credentials
        if (!config('cloudinary.cloud_name')) {
            $this->markTestSkipped('Cloudinary not configured for testing');
        }

        // Create a fake image file
        $file = UploadedFile::fake()->image('test-book-cover.jpg', 600, 800);

        $response = $this->actingAs($this->user)
            ->post(route('managementbuku.store'), [
                'judul' => 'Test Book with Cloudinary',
                'jenis' => 'Fabel',
                'sinopsis' => 'This is a test book to verify Cloudinary integration.',
                'cover' => $file,
            ]);

        $response->assertRedirect(route('managementbuku.index'));
        
        $book = Buku::where('judul', 'Test Book with Cloudinary')->first();
        $this->assertNotNull($book);
        $this->assertStringContains('cloudinary.com', $book->cover);
        
        // Clean up - delete the test book and its image
        if ($book) {
            $book->delete();
        }
    }

    public function test_book_update_with_cloudinary_upload()
    {
        // Skip if not in testing environment
        if (!config('cloudinary.cloud_name')) {
            $this->markTestSkipped('Cloudinary not configured for testing');
        }

        // Create a test book first
        $book = Buku::create([
            'judul' => 'Original Test Book',
            'jenis' => 'Dongeng',
            'sinopsis' => 'Original synopsis',
            'cover' => 'https://res.cloudinary.com/test/image/upload/v123/old-cover.jpg'
        ]);

        $newFile = UploadedFile::fake()->image('new-cover.jpg', 600, 800);

        $response = $this->actingAs($this->user)
            ->put(route('managementbuku.update', $book), [
                'judul' => 'Updated Test Book',
                'jenis' => 'Fabel',
                'sinopsis' => 'Updated synopsis',
                'cover' => $newFile,
            ]);

        $response->assertRedirect(route('managementbuku.index'));
        
        $book->refresh();
        $this->assertEquals('Updated Test Book', $book->judul);
        $this->assertStringContains('cloudinary.com', $book->cover);
        
        // Clean up
        $book->delete();
    }
}