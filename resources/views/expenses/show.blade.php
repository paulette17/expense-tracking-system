<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Details - Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Expense Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('expenses.index') }}">My Expenses</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Expense Details</h4>
            </div>

            <div class="card-body">
                <!-- Status Badge -->
                <div class="mb-4">
                    <span class="badge 
                        @if($expense->status == 'approved') bg-success
                        @elseif($expense->status == 'rejected') bg-danger
                        @else bg-warning text-dark
                        @endif">
                        {{ ucfirst($expense->status) }}
                    </span>
                </div>

                <!-- Expense Information -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Title</label>
                        <div class="fw-semibold">{{ $expense->title }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Category</label>
                        <div>{{ $expense->category->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Amount</label>
                        <div class="fs-5 text-primary fw-bold">₱{{ number_format($expense->amount, 2) }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Expense Date</label>
                        <div>{{ $expense->expense_date->format('F d, Y') }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Submitted By</label>
                        <div>{{ $expense->user->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Submitted On</label>
                        <div>{{ $expense->created_at->format('F d, Y h:i A') }}</div>
                    </div>
                </div>

                @if($expense->description)
                    <div class="mb-4">
                        <label class="form-label text-muted">Description</label>
                        <div>{{ $expense->description }}</div>
                    </div>
                @endif

                @if($expense->notes)
                    <div class="mb-4">
                        <label class="form-label text-muted">Additional Notes</label>
                        <div>{{ $expense->notes }}</div>
                    </div>
                @endif

                @if($expense->receipt_path)
                    <div class="mb-4">
                        <label class="form-label text-muted">Receipt</label><br>
                        <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                            View Receipt
                        </a>
                    </div>
                @endif

                <!-- Approval Information -->
                @if($expense->approvalRecord)
                    <div class="bg-light p-3 rounded mb-4">
                        <h5 class="mb-3">Approval Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-muted">Reviewed By</label>
                                <div>{{ $expense->approvalRecord->approver->name }}</div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-muted">Decision Date</label>
                                <div>{{ $expense->approvalRecord->decision_date->format('F d, Y h:i A') }}</div>
                            </div>
                        </div>
                        @if($expense->approvalRecord->remarks)
                            <div class="mt-2">
                                <label class="form-label text-muted">Remarks</label>
                                <div>{{ $expense->approvalRecord->remarks }}</div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back to List</a>
                    @if($expense->canBeEdited())
                        <div class="d-flex gap-2">
                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-outline-primary">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this expense?')" class="btn btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
