<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
        }
        .date-range {
            text-align: center;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .table td.amount {
            text-align: right;
        }
        .badge-status {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 10px;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f8f9fa;
            text-align: right;
        }
    </style>
</head>
<body class="bg-white p-4">
    <h2>Expense Report</h2>
    <div class="date-range">
        From {{ \Carbon\Carbon::parse($validated['start_date'])->format('M d, Y') }} 
        to {{ \Carbon\Carbon::parse($validated['end_date'])->format('M d, Y') }}
    </div>

    <table class="table table-bordered table-sm align-middle">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Category</th>
                <th>Description</th>
                <th class="text-end">Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                    <td>{{ $expense->user->name ?? '—' }}</td>
                    <td>{{ $expense->category->name ?? '—' }}</td>
                    <td>{{ $expense->description ?? '—' }}</td>
                    <td class="amount">₱{{ number_format($expense->amount, 2) }}</td>
                    <td>
                        @php
                            $status = strtolower($expense->status);
                            $badgeClass = match($status) {
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                'pending' => 'bg-warning text-dark',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge badge-status {{ $badgeClass }}">
                            {{ ucfirst($expense->status) }}
                        </span>
                    </td>
                </tr>
                @php $total += $expense->amount; @endphp
            @endforeach
            <tr class="total-row">
                <td colspan="4">Total</td>
                <td class="amount">₱{{ number_format($total, 2) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
