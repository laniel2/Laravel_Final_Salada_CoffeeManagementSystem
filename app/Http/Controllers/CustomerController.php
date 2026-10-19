<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $records = Customer::latest()->paginate(10);

        return view('customers.index', compact('records'));
    }

    public function create()
    {
        $record = new Customer();

        return view('customers.form', compact('record'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $record)
    {
        $record->load('orders');
        return view('customers.show', compact('record'));
    }

    public function edit(Customer $record)
    {
        return view('customers.form', compact('record'));
    }

    public function update(Request $request, Customer $record)
    {
        $data = $request->validate($this->rules($record->id));
        $record->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $record)
    {
        try {
            $record->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Cannot delete this record because another record uses it.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    private function rules($id = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email' . ($id ? ',' . $id : ''),
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ];
    }
}
