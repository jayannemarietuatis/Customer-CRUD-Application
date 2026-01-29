<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        return Customer::all();
    }

    // Create a new customer
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:customers',
            'contact_number' => 'required|string',
        ]);

        return Customer::create($validated);
    }

    // Show one customer
    public function show(Customer $customer)
    {
        return $customer;
    }

    // Update customer info
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:customers,email,' . $customer->id,
            'contact_number' => 'string',
        ]);

        $customer->update($validated);
        return $customer;
    }

    // Delete a customer
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}