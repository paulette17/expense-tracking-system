<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Report Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light p-4">
    <div class="container">
        <h2 class="h4 fw-bold mb-4">Expense Report Results</h2>

        <p><strong>Date Range:</strong> {{ $filters['start_date'] }} – {{ $filters['end_date'] }}</p>
        @if(!empty($filters['status']))
            <p><strong>Status:</strong> {{ ucfirst($filters['status']) }}</p>
        @endif
        @if(!empty($filters['category_id']))
            <p><strong>Category ID:</strong> {{ $filters['category_id'] }}</p>
        @endif

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover table-sm align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th class="text-end">Amount (₱)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->expense_date }}</td>
                            <td>{{ $expense->user->name ?? 'N/A' }}</td>
                            <td>{{ $expense->category->name ?? 'N/A' }}</td>
                            <td>{{ $expense->title }}</td>
                            <td class="text-end">{{ number_format($expense->amount, 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($expense->status === 'approved') bg-success
                                    @elseif($expense->status === 'rejected') bg-danger
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ ucfirst($expense->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('reports.index') }}" class="btn btn-primary">
                Back to Report Filters
            </a>
        </div>
    </div>
</body>
</html>
