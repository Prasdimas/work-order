<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // Pastikan HasApiTokens digunakan

    protected $fillable = ['username', 'password', 'role_id'];
    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'assigned_operator_id');
    }
}
