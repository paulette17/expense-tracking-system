<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals - Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Expense Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('expenses.index') }}">All Expenses</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('approvals.index') }}">Pending Approvals</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white">{{ auth()->user()->name }}</span>
                    <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
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

        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">Pending Approvals</h2>
                <div class="text-center">
                    <div class="badge bg-warning text-dark">Pending</div>
                    <div class="fs-3 fw-bold text-warning">{{ $pendingExpenses->total() }}</div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                @if($pendingExpenses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingExpenses as $expense)
                                    <tr>
                                        <td>{{ $expense->user->name ?? 'Unknown' }}</td>
                                        <td>{{ $expense->title ?? 'Untitled' }}</td>
                                        <td>₱{{ number_format($expense->amount, 2) }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('approvals.approve', $expense->id) }}" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success me-1">✅ Approve</button>
                                            </form>

                                            <form method="POST" action="{{ route('approvals.reject', $expense->id) }}" class="d-inline">
                                                @csrf
                                                <input type="text" name="remarks" placeholder="Reason (optional)" class="form-control form-control-sm mb-2">
                                                <button class="btn btn-sm btn-danger">❌ Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 text-center text-muted">No pending approvals found.</div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
