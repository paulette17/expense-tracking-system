<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Expense Report - Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('approvals.index') }}">Approvals</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('reports.index') }}">Reports</a></li>
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
        <!-- Page Header -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h2 class="h4 mb-1">Generate Expense Report</h2>
                <p class="text-muted mb-0">Select a date range and filters to preview or download your report.</p>
            </div>
        </div>

        <!-- Report Form -->
        <form method="POST" action="{{ route('reports.generate') }}" class="card shadow-sm p-4">
            @csrf

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date *</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="category_id" class="form-label">Category (Optional)</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status (Optional)</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-outline-secondary">Clear</button>
                <button type="submit" name="action" value="preview" class="btn btn-primary">Preview Report</button>
            </div>
        </form>
    </div>
</body>
</html>
