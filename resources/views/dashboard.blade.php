<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Expense Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a></li>
                    @if(auth()->user()->isFinanceStaff() || auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('approvals.index') }}">Approvals</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Reports</a></li>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                    @endif
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-white fw-semibold">{{ auth()->user()->name }}</span>
                    <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Welcome Message -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h2 class="card-title fw-bold">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-muted">Here's your expense tracking overview</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary text-white rounded p-3">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total Expenses</p>
                            <h4 class="fw-semibold mb-0">{{ $stats['total_expenses'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-warning text-white rounded p-3">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Pending</p>
                            <h4 class="fw-semibold mb-0">{{ $stats['pending_expenses'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success text-white rounded p-3">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Approved</p>
                            <h4 class="fw-semibold mb-0">{{ $stats['approved_expenses'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-info text-white rounded p-3">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-muted mb-0 small">Total Amount</p>
                            <h4 class="fw-semibold mb-0">₱{{ number_format($stats['total_amount'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Quick Actions</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('expenses.create') }}" class="btn btn-primary w-100">+ New Expense</a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary w-100">View All Expenses</a>
                    </div>
                    @if(auth()->user()->isFinanceStaff() || auth()->user()->isAdmin())
                        <div class="col-md-4">
                            <a href="{{ route('approvals.index') }}" class="btn btn-success w-100">Pending Approvals</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Expenses -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Recent Expenses</h5>
                @if($recentExpenses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentExpenses as $expense)
                                <tr>
                                    <td>{{ $expense->title }}</td>
                                    <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                    <td>₱{{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->expense_date->format('M d, Y') }}</td>
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
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No expenses yet. Create your first expense!</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
