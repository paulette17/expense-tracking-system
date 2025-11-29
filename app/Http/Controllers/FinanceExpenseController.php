<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;
use App\Models\AuditLog;

class FinanceExpenseController extends Controller
{
    // Show edit form for a pending expense
    public function edit(Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending expenses can be edited.');
        }

        $categories = Category::all();
        return view('finance.expenses.edit', compact('expense', 'categories'));
    }

    // Update expense details
    public function update(Request $request, Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending expenses can be updated.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:500',
        ]);

        $old = $expense->toArray();

        $expense->update($validated);

        AuditLog::logActivity(
            'finance_edit',
            $expense,
            'Finance staff updated expense details',
            $old,
            $expense->toArray()
        );

        return redirect()->route('approvals.index')->with('success', 'Expense updated successfully.');
    }

    // Delete invalid or duplicate expense
    public function destroy(Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending expenses can be deleted.');
        }

        $expense->delete();

        AuditLog::logActivity(
            'finance_delete',
            $expense,
            'Finance staff deleted an invalid or duplicate expense record.'
        );

        return redirect()->route('approvals.index')->with('success', 'Expense deleted successfully.');
    }
}
