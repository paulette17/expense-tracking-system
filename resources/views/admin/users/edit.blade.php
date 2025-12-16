@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit User</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control" 
                                value="{{ old('name', $user->name) }}" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control" 
                                value="{{ old('email', $user->email) }}" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select 
                                name="department_id" 
                                id="department_id" 
                                class="form-select" 
                                required
                            >
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $department)
                                    <option 
                                        value="{{ $department->id }}" 
                                        {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}
                                    >
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select 
                                name="role" 
                                id="role" 
                                class="form-select" 
                                required
                            >
                                <option value="">-- Select Role --</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="finance_staff" {{ old('role', $user->role) == 'finance_staff' ? 'selected' : '' }}>finance_staff</option>
                                <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning text-white">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection