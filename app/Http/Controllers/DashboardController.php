<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Stats based on user role
        if ($user->isEmployee()) {
            $stats = [
                'total_expenses' => $user->expenses()->count(),
                'pending_expenses' => $user->expenses()->where('status', 'pending')->count(),
                'approved_expenses' => $user->expenses()->where('status', 'approved')->count(),
                'rejected_expenses' => $user->expenses()->where('status', 'rejected')->count(),
                'total_amount' => $user->expenses()->where('status', 'approved')->sum('amount'),
            ];
            
            $recentExpenses = $user->expenses()
                ->with('category')
                ->latest()
                ->take(5)
                ->get();
                
        } else {
            // Finance staff and admin see all data
            $stats = [
                'total_expenses' => Expense::count(),
                'pending_expenses' => Expense::where('status', 'pending')->count(),
                'approved_expenses' => Expense::where('status', 'approved')->count(),
                'rejected_expenses' => Expense::where('status', 'rejected')->count(),
                'total_amount' => Expense::where('status', 'approved')->sum('amount'),
                'total_users' => User::where('role', 'employee')->count(),
            ];
            
            $recentExpenses = Expense::with(['user', 'category'])
                ->latest()
                ->take(5)
                ->get();
        }

        // Monthly breakdown for current year
        $monthlyData = Expense::where('status', 'approved')
            ->whereYear('expense_date', now()->year)
            ->select(
                DB::raw('MONTH(expense_date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Category breakdown
        $categoryData = Category::withSum([
            'expenses' => function($query) {
                $query->where('status', 'approved');
            }
        ], 'amount')->get();

        return view('dashboard', compact('stats', 'recentExpenses', 'monthlyData', 'categoryData'));
    }
}
