<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ApprovalRecord;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingExpenses = Expense::where('status', 'pending')
            ->with(['user', 'category'])
            ->orderBy('created_at', 'asc')
            ->paginate(15);

        return view('approvals.index', compact('pendingExpenses'));
    }

    public function approve(Request $request, Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return back()->with('error', 'This expense has already been processed.');
        }

        $validated = $request->validate([
            'remarks' => 'nullable|string|max:500',
        ]);

        $expense->update(['status' => 'approved']);

        ApprovalRecord::create([
            'expense_id'    => $expense->id,
            'approved_by'   => auth()->id(),
            'decision'      => 'approved',
            'remarks'       => $validated['remarks'] ?? null,
            'decision_date' => now(),
        ]);

        AuditLog::logActivity(
            'approved',
            $expense,
            "Expense '" . ($expense->title ?? 'Untitled') . "' approved by " . (auth()->user()->name ?? 'System'),
            ['status' => 'pending'],
            ['status' => 'approved']
        );

        return back()->with('success', 'Expense approved successfully.');
    }

    public function reject(Request $request, Expense $expense)
    {
        if ($expense->status !== 'pending') {
            return back()->with('error', 'This expense has already been processed.');
        }

        $validated = $request->validate([
            'remarks' => 'nullable|string|max:500',
        ]);

        $expense->update(['status' => 'rejected']);

        ApprovalRecord::create([
            'expense_id'    => $expense->id,
            'approved_by'   => auth()->id(),
            'decision'      => 'rejected',
            'remarks'       => $validated['remarks'],
            'decision_date' => now(),
        ]);

        AuditLog::logActivity(
            'rejected',
            $expense,
            "Expense '" . ($expense->title ?? 'Untitled') . "' rejected by " . (auth()->user()->name ?? 'System'),
            ['status' => 'pending'],
            ['status' => 'rejected']
        );

        return back()->with('success', 'Expense rejected successfully.');
    }
}
