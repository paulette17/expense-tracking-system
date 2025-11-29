<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Expenses - Expense Tracker</title>
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
                    @if(auth()->user()->isFinanceStaff() || auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('approvals.index') }}">Approvals</a></li>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                    @endif
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
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">My Expenses</h2>
                    <p class="text-muted mb-0">Manage your expense submissions</p>
                </div>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">+ New Expense</a>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                @if($expenses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                    <tr>
                                        <td>
                                            <strong>{{ $expense->title }}</strong><br>
                                            @if($expense->description)
                                                <small class="text-muted">{{ Str::limit($expense->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $expense->category->name ?? 'N/A' }}</td>
                                        <td class="fw-semibold">₱{{ number_format($expense->amount, 2) }}</td>
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
                                        <td>
                                            <a href="{{ route('expenses.show', $expense) }}" class="btn btn-sm btn-outline-primary me-1">View</a>
                                            @if($expense->canBeEdited())
                                                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this expense?')" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-3 bg-light">
                        {{ $expenses->links() }}
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <svg class="mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h5>No expenses</h5>
                        <p>Get started by creating a new expense.</p>
                        <a href="{{ route('expenses.create') }}" class="btn btn-primary mt-2">+ New Expense</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
