<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isFinanceStaff() || $user->isAdmin()) {
            // Finance staff and admin see all expenses
            $expenses = Expense::with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            // Employees only see their own expenses
            $expenses = $user->expenses()
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date|before_or_equal:today',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        // Handle receipt upload
        if ($request->hasFile('receipt')) {
            $validated['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }

        $expense = Expense::create($validated);

        // Log activity
        AuditLog::logActivity(
            'created',
            $expense,
            "Expense '{$expense->title}' created for ₱" . number_format($expense->amount, 2),
            null,
            $expense->toArray()
        );

        return redirect()->route('expenses.index')
            ->with('success', 'Expense created successfully and submitted for approval.');
    }

    /**
     * Display the specified expense.
     */
    public function show(Expense $expense)
    {
        $user = auth()->user();

        if (!$user->isFinanceStaff() && !$user->isAdmin() && $expense->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $expense->load(['user', 'category', 'approvalRecord.approver']);

        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense)
    {
        $user = auth()->user();

        if ($expense->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$expense->canBeEdited()) {
            return redirect()->route('expenses.index')
                ->with('error', 'Only pending expenses can be edited.');
        }

        $categories = Category::where('is_active', true)->get();

        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $user = auth()->user();

        if ($expense->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$expense->canBeEdited()) {
            return redirect()->route('expenses.index')
                ->with('error', 'Only pending expenses can be edited.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date|before_or_equal:today',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string',
        ]);

        $oldValues = $expense->toArray();

        // Handle receipt upload
        if ($request->hasFile('receipt')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $validated['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }

        $expense->update($validated);

        // Log activity
        AuditLog::logActivity(
            'updated',
            $expense,
            "Expense '{$expense->title}' updated.",
            $oldValues,
            $expense->fresh()->toArray()
        );

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense)
    {
        $user = auth()->user();

        if ($expense->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if (!$expense->canBeEdited()) {
            return redirect()->route('expenses.index')
                ->with('error', 'Only pending expenses can be deleted.');
        }

        $oldValues = $expense->toArray();

        // Delete attached receipt if any
        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        $expense->delete();

        // Log activity
        AuditLog::logActivity(
            'deleted',
            $expense,
            "Expense '{$expense->title}' deleted.",
            $oldValues,
            null
        );

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
