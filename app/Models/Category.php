<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'monthly_limit',
        'is_active',
    ];

    protected $casts = [
        'monthly_limit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationship
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Helper method to get total expenses for a month
    public function getTotalExpensesForMonth($month, $year)
    {
        return $this->expenses()
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->where('status', 'approved')
            ->sum('amount');
    }

    // Check if category is over limit
    public function isOverLimit($month, $year)
    {
        if (!$this->monthly_limit) {
            return false;
        }
        return $this->getTotalExpensesForMonth($month, $year) > $this->monthly_limit;
    }
}