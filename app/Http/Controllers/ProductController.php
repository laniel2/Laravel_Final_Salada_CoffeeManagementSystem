<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $records = Product::with('category')->latest()->paginate(10);

        return view('products.index', compact('records'));
    }

    public function create()
    {
        $record = new Product();
        $categories = Category::orderBy('name')->get();

        return view('products.form', compact('record', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $record)
    {
        $record->load('category');
        return view('products.show', compact('record'));
    }

    public function edit(Product $record)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.form', compact('record', 'categories'));
    }

    public function update(Request $request, Product $record)
    {
        $data = $request->validate($this->rules($record->id));
        $record->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $record)
    {
        if ($record->orderItems()->exists()) {
            return back()->with('error', 'This product appears in order items and cannot be deleted.');
        }

        try {
            $record->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Cannot delete this record because another record uses it.');
        }

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    private function rules($id = null): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->where(fn ($query) => $query->where('category_id', request('category_id')))->ignore($id)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }
}
