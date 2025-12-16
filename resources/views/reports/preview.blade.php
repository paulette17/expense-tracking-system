<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Report Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light text-dark">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3 text-primary fw-bold mb-4">Expense Report</h1>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0 text-muted">
                        <strong>From:</strong> {{ $validated['start_date'] }}  
                        <span class="mx-2">—</span>  
                        <strong>To:</strong> {{ $validated['end_date'] }}
                    </p>

                    <form method="POST" action="{{ route('reports.generate') }}">
                        @csrf
                        <input type="hidden" name="start_date" value="{{ $validated['start_date'] }}">
                        <input type="hidden" name="end_date" value="{{ $validated['end_date'] }}">
                        <input type="hidden" name="category_id" value="{{ $validated['category_id'] ?? '' }}">
                        <input type="hidden" name="status" value="{{ $validated['status'] ?? '' }}">
                    
                    </form>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th class="text-end">Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                    <td>{{ $expense->user->name ?? '-' }}</td>
                                    <td>{{ $expense->category->name ?? '-' }}</td>
                                    <td>{{ $expense->title }}</td>
                                    <td class="text-end">₱{{ number_format($expense->amount, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($expense->status == 'approved') bg-success
                                            @elseif($expense->status == 'rejected') bg-danger
                                            @else bg-warning text-dark
                                            @endif">
                                            {{ ucfirst($expense->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No expenses found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Totals Summary -->
                @if($expenses->count() > 0)
                    <div class="mt-4 p-3 bg-light border rounded">
                        <h5 class="mb-2">Summary</h5>
                        <p class="mb-1">Total Records: <strong>{{ $expenses->count() }}</strong></p>
                        <p>Total Amount: <strong>₱{{ number_format($expenses->sum('amount'), 2) }}</strong></p>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="mt-4 text-center">
                    <a href="{{ route('reports.index') }}" class="text-primary text-decoration-underline small">← Back to Reports</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
