<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Report - Expense Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @media print {
            nav, button, .no-print { display: none !important; }
            body { background: white; }
            .shadow { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Expense Tracker</a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                <span class="text-white">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <!-- Report Header -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="h4 fw-bold">Expense Report</h2>
                    <p class="text-muted mb-1">
                        {{ \Carbon\Carbon::parse($validated['start_date'])->format('F d, Y') }} – 
                        {{ \Carbon\Carbon::parse($validated['end_date'])->format('F d, Y') }}
                    </p>
                    @if(isset($validated['category_id']) && $validated['category_id'])
                        <p class="small text-muted mb-1">
                            Category: {{ $categories->find($validated['category_id'])->name }}
                        </p>
                    @endif
                    @if(isset($validated['status']) && $validated['status'])
                        <p class="small text-muted mb-0">
                            Status: {{ ucfirst($validated['status']) }}
                        </p>
                    @endif
                </div>
                <div class="text-end">
                    <p class="small text-muted mb-1">Total Amount</p>
                    <p class="fs-3 fw-bold text-primary mb-0">₱{{ number_format($totalAmount, 2) }}</p>
                    <p class="small text-muted">{{ $expenses->count() }} expense(s)</p>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        @php
            $categoryBreakdown = $expenses->groupBy('category_id')->map(function($items) {
                return [
                    'name' => $items->first()->category->name,
                    'count' => $items->count(),
                    'total' => $items->sum('amount')
                ];
            })->sortByDesc('total');
        @endphp

        @if($categoryBreakdown->count() > 0)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Category Breakdown</h5>
                <div class="row g-3">
                    @foreach($categoryBreakdown as $breakdown)
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded border">
                            <h6 class="fw-semibold mb-1">{{ $breakdown['name'] }}</h6>
                            <p class="fs-5 fw-bold text-primary mb-1">₱{{ number_format($breakdown['total'], 2) }}</p>
                            <p class="small text-muted mb-0">{{ $breakdown['count'] }} expense(s)</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Expense Details Table -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Expense Details</h5>
            </div>

            @if($expenses->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th class="text-end">Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                            <td>{{ $expense->user->name }}</td>
                            <td>{{ $expense->title }}</td>
                            <td>{{ $expense->category->name }}</td>
                            <td class="text-end fw-semibold">₱{{ number_format($expense->amount, 2) }}</td>
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
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-semibold">Total:</td>
                            <td class="text-end fw-bold text-primary">₱{{ number_format($totalAmount, 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="text-center p-4 text-muted">
                No expenses found for the selected criteria.
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back to Reports</a>
            <button onclick="window.print()" class="btn btn-primary">Print Report</button>
        </div>
    </div>
</body>
</html>
