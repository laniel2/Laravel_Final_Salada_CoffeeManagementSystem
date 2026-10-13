<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $records = Category::latest()->paginate(10);

        return view('categories.index', compact('records'));
    }

    public function create()
    {
        $record = new Category();

        return view('categories.form', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $record)
    {
        return view('categories.show', compact('record'));
    }

    public function edit(Category $record)
    {
        return view('categories.form', compact('record'));
    }

    public function update(Request $request, Category $record)
    {
        $data = $request->validate($this->rules($record->id));
        $record->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $record)
    {
        try {
            $record->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Cannot delete this record because another record uses it.');
        }

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    private function rules($id = null): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name' . ($id ? ',' . $id : ''),
            'description' => 'nullable|string',
        ];
    }
}
