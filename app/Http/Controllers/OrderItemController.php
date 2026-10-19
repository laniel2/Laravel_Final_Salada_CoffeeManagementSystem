<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order.customer', 'product'])
            ->latest()
            ->paginate(10);

        return view('order-items.index', compact('orderItems'));
    }

    public function create()
    {
        $record = new OrderItem();
        $orders = Order::with('customer')->latest()->get();
        $products = Product::orderBy('name')->get();

        return view('order-items.form', compact('record', 'orders', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $product = Product::findOrFail($data['product_id']);
        $data['unit_price'] = $product->price;
        $data['subtotal'] = $product->price * $data['quantity'];
        OrderItem::create($data);
        $this->updateOrderTotal($data['order_id']);

        return redirect()->route('order-items.index')->with('success', 'OrderItem created successfully.');
    }

    public function show(OrderItem $record)
    {
        $record->load(['order.customer', 'product']);
        return view('order-items.show', compact('record'));
    }

    public function edit(OrderItem $record)
    {
        $orders = Order::with('customer')->latest()->get();
        $products = Product::orderBy('name')->get();
        return view('order-items.form', compact('record', 'orders', 'products'));
    }

    public function update(Request $request, OrderItem $record)
    {
        $data = $request->validate($this->rules($record->id));
        $previousOrderId = $record->order_id;
        $product = Product::findOrFail($data['product_id']);
        $data['unit_price'] = $product->price;
        $data['subtotal'] = $product->price * $data['quantity'];
        $record->update($data);
        $this->updateOrderTotal($previousOrderId);
        if ($previousOrderId !== (int) $data['order_id']) $this->updateOrderTotal((int) $data['order_id']);

        return redirect()->route('order-items.index')->with('success', 'OrderItem updated successfully.');
    }

    public function destroy(OrderItem $record)
    {
        $orderId = $record->order_id;
        try {
            $record->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Cannot delete this record because another record uses it.');
        }

        $this->updateOrderTotal($orderId);
        return redirect()->route('order-items.index')->with('success', 'Order item deleted successfully.');
    }

    private function rules($id = null): array
    {
        return [
            'order_id' => ['required', 'exists:orders,id'],
            'quantity' => 'required|integer|min:1',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('order_items', 'product_id')->where(fn ($query) => $query->where('order_id', request('order_id')))->ignore($id),
            ],
        ];
    }

    private function updateOrderTotal(int $orderId): void
    {
        Order::whereKey($orderId)->update([
            'total_amount' => OrderItem::where('order_id', $orderId)->sum('subtotal'),
        ]);
    }
}
