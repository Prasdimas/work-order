<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\WorkOrder;
use App\Models\WorkOrderProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkOrderController extends Controller
{
    // Production Manager hanya yang bisa membuat work order
    public function __construct()
    {
        $this->middleware('role:Production Manager');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:100',
            'quantity' => 'required|integer',
            'due_date' => 'nullable|date',
            'assigned_operator_id' => 'required|exists:users,id',
        ]);

        // Membuat nomor work order otomatis
        $workOrderNumber = 'WO-' . date('Ymd') . '-' . Str::padLeft(rand(1, 999), 3, '0');

        $workOrder = WorkOrder::create([
            'work_order_number' => $workOrderNumber,
            'product_name' => $validated['product_name'],
            'quantity' => $validated['quantity'],
            'due_date' => $validated['due_date'],
            'assigned_operator_id' => $validated['assigned_operator_id'],
        ]);
        WorkOrderProgress::create([
            'work_order_id' => $workOrder->id,
            'status' => 'pending',
            'quantity' => $validated['quantity'],
            'notes' => '',
        ]);
        return response()->json(['message' => 'Work Order created', 'work_order' => $workOrder], 201);
    }

    public function save(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'due_date' => 'required|date',
            'status' => 'required|max:50',
            'assigned_operator_id' => 'required|integer',
            'id' => 'nullable|exists:work_orders,id',
        ]);
        $id = $request->id;

        if ($id) {
            // Update existing work order
            $workOrder = WorkOrder::findOrFail($id);
            $workOrder->status = $request->status;
            $workOrder->assigned_operator_id = $request->assigned_operator_id ?? $workOrder->assigned_operator_id;
            $workOrder->save();

            return response()->json(['message' => 'Work order updated successfully.'], 200);
        } else {
            $workOrderNumber = 'WO-' . date('Ymd') . '-' . Str::padLeft(rand(1, 999), 3, '0');
            $workOrder = WorkOrder::create([
                'product_name' => $request->product_name,
                'quantity' => $request->quantity,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'assigned_operator_id' => $request->assigned_operator_id,
                'work_order_number' => $workOrderNumber,
            ]);

            return response()->json(['message' => 'Work order created successfully.'], 201);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $workOrder = WorkOrder::findOrFail($id);
        $workOrder->status = $request->status;
        $workOrder->assigned_operator_id = $request->assigned_operator_id ?? $workOrder->assigned_operator_id;
        $workOrder->save();

        return response()->json(['message' => 'Work Order updated', 'work_order' => $workOrder]);
    }

    public function listWorkOrders(Request $request)
    {
        $statusFilter = $request->get('status');
        $dateFilter = $request->get('due_date');

        $workOrders = WorkOrder::with('operator')
            ->when($statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($dateFilter, function ($query, $date) {
                return $query->whereDate('due_date', $date);
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

    public function report(Request $request)
    {
        $report = WorkOrder::selectRaw('product_name, status, sum(quantity) as total_quantity')
            ->groupBy('product_name', 'status')
            ->get();

        return response()->json($report);
    }
    public function getCompletedStatusPerUser()
    {
        // Mengambil data pengguna dengan role_id = 2
        $result = DB::table('users')
            ->where('role_id', 2) // Filter berdasarkan role_id = 2
            ->leftJoin('work_orders', 'users.id', '=', 'work_orders.assigned_operator_id') // Gabungkan dengan work_orders
            ->leftJoin('work_order_progress', 'work_orders.id', '=', 'work_order_progress.work_order_id') // Gabungkan dengan work_order_progress
            ->select(
                'users.id',
                'users.username',
                DB::raw('COALESCE(SUM(CASE WHEN work_order_progress.status = "Completed" THEN work_order_progress.quantity ELSE 0 END), 0) as complete_quantity')
            ) // Hitung jumlah kuantitas dengan status 'Completed'
            ->groupBy('users.id', 'users.username') // Kelompokkan berdasarkan user
            ->get(); // Ambil hasilnya

        // Mengembalikan hasil dalam format JSON
        return response()->json($result);
    }




    public function getWorkOrderReport(Request $request)
    {
        // Ambil seluruh data work orders beserta progress-nya
        $workOrders = WorkOrder::with(['progress' => function ($query) {
            // Ambil status dan total kuantitas untuk setiap status yang terkait dengan work order
            $query->select('work_order_id', 'status')
                ->selectRaw('SUM(quantity) as total_quantity')
                ->groupBy('work_order_id', 'status');
        }])->get();

        // Strukturkan data agar sesuai dengan format yang diinginkan
        $report = $workOrders->map(function ($workOrder) {
            // Strukturkan array status
            $statuses = $workOrder->progress->map(function ($progress) {
                return [
                    'status' => $progress->status,
                    'total_quantity' => $progress->total_quantity,
                ];
            })->toArray();

            // Pastikan ada semua status (Pending, In Progress, Completed, Canceled)
            $allStatuses = ['Pending', 'Progress', 'Completed', 'Canceled'];
            foreach ($allStatuses as $status) {
                if (!collect($statuses)->contains('status', $status)) {
                    $statuses[] = [
                        'status' => $status,
                        'total_quantity' => 0
                    ];
                }
            }

            return [
                'work_order_id' => $workOrder->id,
                'work_order_name' => $workOrder->product_name,
                'work_order_status' => $statuses,
            ];
        });

        return response()->json($report);
    }


    public function delete(Request $request)
    {
        $id = $request->id;
        $workOrder = WorkOrder::find($id);

        if (!$workOrder) {
            return response()->json(['message' => 'Work order not found.'], 404);
        }

        $workOrder->delete();

        return response()->json(['message' => 'Work order deleted successfully.'], 200);
    }
}
