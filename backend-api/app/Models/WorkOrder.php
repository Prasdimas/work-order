<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_orders';

    // Kolom yang dapat diisi
    protected $fillable = [
        'work_order_number',
        'product_name',
        'quantity',
        'due_date',
        'status',
        'assigned_operator_id'
    ];

    // Relasi ke tabel `users` (Operator)
    public function operator()
    {
        return $this->belongsTo(User::class, 'assigned_operator_id');
    }

    // Relasi ke tabel `work_order_progress`
    public function progress()
    {
        return $this->hasMany(WorkOrderProgress::class, 'work_order_id');
    }
}
