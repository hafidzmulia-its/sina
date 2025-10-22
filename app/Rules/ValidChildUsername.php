<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class ValidChildUsername implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if user exists
        $childUser = User::where('username', $value)->first();
        
        if (!$childUser) {
            $fail('Username anak tidak ditemukan.');
            return;
        }
        
        // Check if user is a child
        if ($childUser->role !== 'anak') {
            $fail('Username yang dipilih bukan seorang anak.');
            return;
        }
        
        // Check if child already has a parent
        if ($childUser->parent_user_username) {
            $fail('Anak ini sudah memiliki orang tua.');
            return;
        }
    }
}