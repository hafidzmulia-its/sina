<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Buku;

class MigrateImagesToCloudinary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:migrate-to-cloudinary {--dry-run : Show what would be migrated without actually doing it} {--test : Process only one image for testing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all images from public/images to Cloudinary and update database records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No actual changes will be made');
            $this->newLine();
        }

        $imagesPath = public_path('images');
        
        if (!File::exists($imagesPath)) {
            $this->error('❌ Images directory not found: ' . $imagesPath);
            return 1;
        }

        // Get all image files
        $imageFiles = File::allFiles($imagesPath);
        
        // For testing - limit to first image
        if ($this->option('test')) {
            $imageFiles = array_slice($imageFiles, 0, 1);
            $this->warn('🧪 Test mode: Processing only 1 image');
        }
        
        $totalFiles = count($imageFiles);
        
        if ($totalFiles === 0) {
            $this->info('ℹ️  No images found in public/images directory');
            return 0;
        }

        $this->info("📁 Found {$totalFiles} images to migrate");
        $this->newLine();

        $successCount = 0;
        $errorCount = 0;
        $urlMappings = [];

        // Create progress bar
        $bar = $this->output->createProgressBar($totalFiles);
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');
        $bar->setMessage('Starting migration...');
        $bar->start();

        foreach ($imageFiles as $file) {
            $relativePath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $relativePath = str_replace('\\', '/', $relativePath); // Normalize path separators
            
            $bar->setMessage("Migrating: {$file->getFilename()}");
            
            try {
                if (!$isDryRun) {
                    // Upload directly to Cloudinary using HTTP API (unsigned upload)
                    $cloudName = config('cloudinary.cloud_name', env('CLOUDINARY_CLOUD_NAME'));
                    
                    if (!$cloudName) {
                        throw new \Exception('Cloudinary cloud name not configured');
                    }
                    
                    $publicId = 'images/' . pathinfo($file->getFilename(), PATHINFO_FILENAME);
                    
                    // Use signed upload (more reliable)
                    $apiKey = config('cloudinary.api_key', env('CLOUDINARY_API_KEY', env('CLOUDINARY_KEY')));
                    $apiSecret = config('cloudinary.api_secret', env('CLOUDINARY_API_SECRET', env('CLOUDINARY_SECRET')));
                    
                    if (!$apiKey || !$apiSecret) {
                        throw new \Exception('Cloudinary API credentials not configured');
                    }
                    
                    $timestamp = time();
                    
                    // Correct signature generation according to Cloudinary docs
                    $signature = hash('sha1', "public_id={$publicId}&timestamp={$timestamp}{$apiSecret}");
                    
                    // Only bypass SSL in local development
                    $httpClient = app()->environment('local') 
                        ? Http::withOptions(['verify' => false])
                        : Http::withOptions([]);
                    
                    $response = $httpClient->asMultipart()->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                        'file' => fopen($file->getPathname(), 'r'),
                        'public_id' => $publicId,
                        'api_key' => $apiKey,
                        'timestamp' => $timestamp,
                        'signature' => $signature
                    ]);
                    
                    if ($response->successful()) {
                        $result = $response->json();
                        $cloudinaryUrl = $result['secure_url'];
                        $urlMappings[$relativePath] = $cloudinaryUrl;
                    } else {
                        throw new \Exception('Upload failed: ' . $response->body());
                    }
                    
                    $this->line("\n✅ Uploaded: {$file->getFilename()} -> {$cloudinaryUrl}");
                } else {
                    $this->line("\n🔍 Would upload: {$relativePath}");
                }
                
                $successCount++;
            } catch (\Exception $e) {
                $this->line("\n❌ Failed to upload {$file->getFilename()}: " . $e->getMessage());
                $errorCount++;
            }
            
            $bar->advance();
        }

        $bar->setMessage('Migration completed!');
        $bar->finish();
        $this->newLine(2);

        // Update database records
        if (!$isDryRun) {
            $this->info('📝 Updating database records...');
            $this->updateDatabaseRecords($urlMappings);
        } else {
            $this->info('🔍 Would update database records with new URLs');
        }

        // Summary
        $this->newLine();
        $this->info("📊 Migration Summary:");
        $this->info("   ✅ Successfully processed: {$successCount}");
        if ($errorCount > 0) {
            $this->error("   ❌ Failed: {$errorCount}");
        }
        
        if (!$isDryRun) {
            $this->info("\n🎉 Migration completed! You can now:");
            $this->info("   1. Test your application to ensure images load correctly");
            $this->info("   2. Remove the local images: rm -rf public/images");
            $this->info("   3. Update your .env to use FILESYSTEM_DISK=cloudinary");
        }

        return 0;
    }

    private function updateDatabaseRecords(array $urlMappings)
    {
        $updatedCount = 0;
        
        // Get all books with covers
        $books = Buku::whereNotNull('cover')->get();
        
        foreach ($books as $book) {
            $currentCover = $book->cover;
            
            // Check if we have a mapping for this cover
            if (isset($urlMappings[$currentCover])) {
                $book->cover = $urlMappings[$currentCover];
                $book->save();
                
                $this->line("   📝 Updated book: {$book->judul}");
                $this->line("      Old: {$currentCover}");
                $this->line("      New: {$urlMappings[$currentCover]}");
                
                $updatedCount++;
            }
        }
        
        $this->info("   ✅ Updated {$updatedCount} database records");
    }

    private function generateSignature($publicId, $timestamp, $apiSecret)
    {
        $params = [
            'folder' => 'images',
            'public_id' => $publicId,
            'timestamp' => $timestamp
        ];
        
        // Sort parameters alphabetically
        ksort($params);
        
        // Build the signature string manually to ensure proper format
        $signatureParams = [];
        foreach ($params as $key => $value) {
            $signatureParams[] = $key . '=' . $value;
        }
        
        $signatureString = implode('&', $signatureParams) . $apiSecret;
        return sha1($signatureString);
    }
}
