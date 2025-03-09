<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProgress extends Model
{
    use HasFactory;

    protected $table = 'work_order_progress';

    // Kolom yang dapat diisi
    protected $fillable = [
        'work_order_id',
        'status',
        'quantity',
        'notes'
    ];

    // Relasi ke tabel `work_orders`
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }
}
