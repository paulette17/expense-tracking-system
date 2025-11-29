@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Expense</h4>
                </div>

                <div class="card-body">

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Edit Expense Form --}}
                    <form action="{{ route('expenses.update', $expense->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        {{-- Category --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" 
                                class="form-control" 
                                id="title" 
                                name="title"
                                value="{{ old('title', $expense->title) }}" 
                                required>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="3" 
                                class="form-control">{{ old('description', $expense->description) }}</textarea>
                        </div>

                        {{-- Amount --}}
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount (₱)</label>
                            <input type="number" 
                                step="0.01"
                                class="form-control" 
                                id="amount" 
                                name="amount"
                                value="{{ old('amount', $expense->amount) }}" 
                                required>
                        </div>

                        {{-- Expense Date --}}
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Expense Date</label>
                            <input type="date" 
                                class="form-control" 
                                id="expense_date" 
                                name="expense_date"
                                value="{{ old('expense_date', \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d')) }}" 
                                required>
                        </div>

                        {{-- Receipt Upload --}}
                        <div class="mb-3">
                            <label for="receipt" class="form-label">Receipt (Optional)</label>
                            <input type="file" 
                                   name="receipt" 
                                   id="receipt" 
                                   class="form-control" 
                                   accept="image/*,application/pdf">

                            @if ($expense->receipt_path)
                                <small class="text-muted">
                                    Current Receipt: 
                                    <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank">
                                        View Receipt
                                    </a>
                                </small>
                            @endif
                        </div>

                        {{-- Notes --}}
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="2" 
                                class="form-control">{{ old('notes', $expense->notes) }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning text-white">
                                Update Expense
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
