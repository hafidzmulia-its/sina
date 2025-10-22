<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\History;

class HistorySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        History::truncate();

        $histories = [
            ['user_username' => 'brohafidz', 'buku_id' => 1, 'progress' => 3, 'target' => 5, 'tanggal_record' => '2025-10-17'],
            ['user_username' => 'brohafidz', 'buku_id' => 7, 'progress' => 2, 'target' => 5, 'tanggal_record' => '2025-03-15'],
            ['user_username' => 'admin1', 'buku_id' => 6, 'progress' => 3, 'target' => 7, 'tanggal_record' => '2025-10-10'],
            ['user_username' => 'admin1', 'buku_id' => 10, 'progress' => 4, 'target' => 7, 'tanggal_record' => '2025-10-20'],
            ['user_username' => 'admin2', 'buku_id' => 15, 'progress' => 11, 'target' => 12, 'tanggal_record' => '2025-09-30'],
            ['user_username' => 'admin2', 'buku_id' => 8, 'progress' => 10, 'target' => 12, 'tanggal_record' => '2025-09-05'],
            ['user_username' => 'anak_amir', 'buku_id' => 11, 'progress' => 5, 'target' => 5, 'tanggal_record' => '2025-07-28'],
            ['user_username' => 'anak_bela', 'buku_id' => 14, 'progress' => 1, 'target' => 8, 'tanggal_record' => '2025-01-19'],
            ['user_username' => 'anak_bela', 'buku_id' => 4, 'progress' => 2, 'target' => 8, 'tanggal_record' => '2025-02-08'],
            ['user_username' => 'anak_bela', 'buku_id' => 5, 'progress' => 3, 'target' => 8, 'tanggal_record' => '2025-04-21'],
            ['user_username' => 'rio_junior', 'buku_id' => 2, 'progress' => 4, 'target' => 7, 'tanggal_record' => '2025-06-17'],
            ['user_username' => 'sasa_kecil', 'buku_id' => 3, 'progress' => 5, 'target' => 6, 'tanggal_record' => '2025-08-17'],
            ['user_username' => 'udin_siwa', 'buku_id' => 12, 'progress' => 2, 'target' => 4, 'tanggal_record' => '2025-05-23'],
            ['user_username' => 'bapak_andi', 'buku_id' => 13, 'progress' => 3, 'target' => 6, 'tanggal_record' => '2025-10-15'],
            ['user_username' => 'ibu_santi', 'buku_id' => 9, 'progress' => 8, 'target' => 10, 'tanggal_record' => '2025-10-19']
        ];

        foreach ($histories as $history) {
            History::create($history);
        }
    }
}