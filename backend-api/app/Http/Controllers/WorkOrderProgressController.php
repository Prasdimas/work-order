<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderProgress;
use Illuminate\Http\Request;

class WorkOrderProgressController extends Controller
{
    // Operator hanya yang bisa memperbarui status work order
    public function __construct()
    {
        $this->middleware('role:Operator');
    }
    public function operatorReport(Request $request)
    {
        $report = WorkOrderProgress::selectRaw('work_orders.product_name, sum(work_order_progress.quantity) as total_completed')
            ->join('work_orders', 'work_orders.id', '=', 'work_order_progress.work_order_id')
            ->where('work_order_progress.status', 'Completed')
            ->groupBy('work_orders.product_name')
            ->get();

        return response()->json($report);
    }
    public function listWorkOrders(Request $request)
    {
        $dateFilter = $request->get('due_date');
        $operatorFilter = $request->get('assigned_id');

        $workOrders = WorkOrder::with('operator')
            ->when($dateFilter, function ($query, $date) {
                return $query->whereDate('due_date', $date);
            })
            ->when($operatorFilter, function ($query, $operatorId) {
                return $query->where('assigned_operator_id', $operatorId);
            })
            ->get();

        // Memformat data supaya nama assigned lebih mudah digunakan di frontend
        $workOrders = $workOrders->map(function ($workOrder) {
            return [
                'work_order_id' => $workOrder->id,
                'status' => $workOrder->status,
                'work_order_number' => $workOrder->work_order_number,
                'product_name' => $workOrder->product_name,
                'quantity' => $workOrder->quantity,
                'due_date' => $workOrder->due_date,
                'assigned_to_name' => $workOrder->operator ? $workOrder->operator->username : null,  // Ambil nama dari relasi assignedTo
                'assigned_to_id' => $workOrder->operator ? $workOrder->operator->id : null,
            ];
        });

        return response()->json($workOrders);
    }



    public function updateStatus(Request $request, $id)
    {
        $workOrder = WorkOrder::findOrFail($id);

        // Cek apakah status valid untuk diperbarui
        $request->validate([
            'status' => 'required|in:Progress,Completed',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Menambahkan progress ke tabel work_order_progress
        $progress = WorkOrderProgress::create([
            'work_order_id' => $workOrder->id,
            'status' => $request->status,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        // Update status work order
        $workOrder->status = $request->status;
        $workOrder->save();

        return response()->json(['message' => 'Work order status updated', 'progress' => $progress]);
    }
}
