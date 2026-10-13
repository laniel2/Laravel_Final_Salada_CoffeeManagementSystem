<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])
            ->latest()
            ->paginate(10);

        return view('order-items.index', compact('orderItems'));
    }

    public function create()
    {
        $record = new OrderItem();

        return view('order-items.form', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        OrderItem::create($data);

        return redirect()->route('order-items.index')->with('success', 'OrderItem created successfully.');
    }

    public function show(OrderItem $record)
    {
        return view('order-items.show', compact('record'));
    }

    public function edit(OrderItem $record)
    {
        return view('order-items.form', compact('record'));
    }

    public function update(Request $request, OrderItem $record)
    {
        $data = $request->validate($this->rules($record->id));
        $record->update($data);

        return redirect()->route('order-items.index')->with('success', 'OrderItem updated successfully.');
    }

    public function destroy(OrderItem $record)
    {
        try {
            $record->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Cannot delete this record because another record uses it.');
        }

        return redirect()->route('order-items.index')->with('success', 'OrderItem deleted successfully.');
    }

    private function rules($id = null): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ];
    }
}
