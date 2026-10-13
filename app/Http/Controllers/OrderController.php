<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $records = Order::latest()->paginate(10);

        return view('orders.index', compact('records'));
    }

    public function create()
    {
        $record = new Order();

        return view('orders.form', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $record)
    {
        return view('orders.show', compact('record'));
    }

    public function edit(Order $record)
    {
        return view('orders.form', compact('record'));
    }

    public function update(Request $request, Order $record)
    {
        $data = $request->validate($this->rules($record->id));
        $record->update($data);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $record)
    {
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
            'total_amount' => 'required|numeric|min:0',
        ];
    }
}
