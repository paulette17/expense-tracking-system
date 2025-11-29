<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // Relationships

    
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function approvalRecords()
    {
        return $this->hasMany(ApprovalRecord::class, 'approved_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Helper methods for checking roles
    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function isFinanceStaff()
    {
        return $this->role === 'finance_staff';
    }

    public                function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function department()
{
    return $this->belongsTo(\App\Models\Department::class);
}

}