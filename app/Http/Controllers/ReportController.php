<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Expense;

class ReportController extends Controller
{
    // ✅ Show the report generation form
    public function index()
    {
        // Fetch all categories for the dropdown
        $categories = Category::orderBy('name', 'asc')->get();

        return view('reports.index', compact('categories'));
    }

    // ✅ Handle preview and PDF download
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $query = Expense::with(['user', 'category'])
            ->whereBetween('expense_date', [$validated['start_date'], $validated['end_date']]);

        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $expenses = $query->orderBy('expense_date', 'asc')->get();

        if ($request->input('action') === 'preview') {
            return view('reports.preview', compact('expenses', 'validated'));
        }

        $pdf = \PDF::loadView('reports.preview', compact('expenses', 'validated'));
        return $pdf->download('Expense_Report_' . now()->format('Ymd_His') . '.pdf');
    }
}
