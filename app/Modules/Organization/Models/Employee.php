<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_number', 'full_name', 'email', 'phone',
        'employment_status', 'joined_at', 'left_at',
    ];

    protected $casts = ['joined_at' => 'date', 'left_at' => 'date'];

    public function assignments(): HasMany { return $this->hasMany(EmployeeAssignment::class); }
    public function user(): HasOne { return $this->hasOne(\App\Models\User::class); }

    public function primaryAssignment()
    {
        return $this->assignments()->where('is_primary', true)->whereNull('ends_on')->latest('starts_on');
    }
}