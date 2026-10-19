<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $records = Order::with('customer')->latest()->paginate(10);

        return view('orders.index', compact('records'));
    }

    public function create()
    {
        $record = new Order();
        $customers = Customer::orderBy('name')->get();

        return view('orders.form', compact('record', 'customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        unset($data['total_amount']);
        $data['total_amount'] = 0;
        Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $record)
    {
        $record->load(['customer', 'items.product']);
        return view('orders.show', compact('record'));
    }

    public function edit(Order $record)
    {
        $customers = Customer::orderBy('name')->get();
        return view('orders.form', compact('record', 'customers'));
    }

    public function update(Request $request, Order $record)
    {
        $data = $request->validate($this->rules($record->id));
        unset($data['total_amount']);
        $record->update($data);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $record)
    {
        if ($record->items()->exists()) {
            return back()->with('error', 'Delete this order’s items before deleting the order.');
        }

        try {
            $record->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Cannot delete this record because another record uses it.');
        }

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

    private function rules($id = null): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,preparing,completed,cancelled',
            'total_amount' => 'nullable|numeric|min:0',
        ];
    }
}
