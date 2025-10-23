<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        if ($user->isAnak()) {
            return $this->anakProgress($user);
        } elseif ($user->isOrangTua()) {
            return $this->orangTuaProgress($user);
        }
        
        abort(403, 'Unauthorized access');
    }
    
    private function anakProgress(User $user): View
    {
        // Get child's reading statistics
        $totalBooks = $user->histories()->distinct('buku_id')->count();
        $completedBooks = $user->histories()->completed()->distinct('buku_id')->count();
        $inProgressBooks = $user->histories()->inProgress()->distinct('buku_id')->count();
        
        // Get recent reading activities
        $recentActivities = $user->histories()
            ->with('buku')
            ->latest('tanggal_record')
            ->take(10)
            ->get();
        
        // Calculate weekly progress (last 7 days)
        $weeklyProgress = $user->histories()
            ->where('tanggal_record', '>=', now()->subDays(7))
            ->sum('progress');
            
        // Get reading streak (consecutive days with reading activity)
        $streak = $this->calculateReadingStreak($user);
        
        // Calculate completion rate
        $completionRate = $totalBooks > 0 ? ($completedBooks / $totalBooks) * 100 : 0;
        
        return view('progress.anak', compact(
            'totalBooks',
            'completedBooks', 
            'inProgressBooks',
            'recentActivities',
            'weeklyProgress',
            'streak',
            'completionRate'
        ));
    }
    
    private function orangTuaProgress(User $user): View
    {
        // Get all children's progress
        $children = $user->children()->with(['histories.buku'])->get();
        
        $childrenProgress = $children->map(function ($child) {
            $totalBooks = $child->histories()->distinct('buku_id')->count();
            $completedBooks = $child->histories()->completed()->distinct('buku_id')->count();
            $weeklyProgress = $child->histories()
                ->where('tanggal_record', '>=', now()->subDays(7))
                ->sum('progress');
            $streak = $this->calculateReadingStreak($child);
            
            return [
                'child' => $child,
                'totalBooks' => $totalBooks,
                'completedBooks' => $completedBooks,
                'weeklyProgress' => $weeklyProgress,
                'streak' => $streak,
                'completionRate' => $totalBooks > 0 ? ($completedBooks / $totalBooks) * 100 : 0,
                'recentActivities' => $child->histories()
                    ->with('buku')
                    ->latest('tanggal_record')
                    ->take(5)
                    ->get()
            ];
        });
        
        // Overall family statistics
        $familyStats = [
            'totalChildren' => $children->count(),
            'totalBooksRead' => $children->sum(function($child) {
                return $child->histories()->distinct('buku_id')->count();
            }),
            'totalCompletedBooks' => $children->sum(function($child) {
                return $child->histories()->completed()->distinct('buku_id')->count();
            }),
            'averageCompletionRate' => $childrenProgress->avg('completionRate')
        ];
        
        return view('progress.orangtua', compact('childrenProgress', 'familyStats'));
    }
    
    private function calculateReadingStreak(User $user): int
    {
        $streak = 0;
        $currentDate = now()->startOfDay();
        
        while (true) {
            $hasActivity = $user->histories()
                ->whereDate('tanggal_record', $currentDate)
                ->exists();
                
            if ($hasActivity) {
                $streak++;
                $currentDate->subDay();
            } else {
                break;
            }
        }
        
        return $streak;
    }
}