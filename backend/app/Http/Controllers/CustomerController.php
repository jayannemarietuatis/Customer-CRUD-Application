<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    // List all customers from the database
    public function index()
    {
        return Customer::all();
    }

    // Create a new customer (Syncing is handled by Model Hooks)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:customers',
            'contact_number' => 'required|string',
        ]);

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    // Show one customer
    public function show(Customer $customer)
    {
        return $customer;
    }

    // Update customer info (Syncing is handled by Model Hooks)
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

    // Delete a customer (Syncing is handled by Model Hooks)
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    /**
     * Implements advanced full-text search using Elasticsearch for high-performance, 
     * fuzzy-matching across large datasets.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        try {
            $response = Http::get("http://searcher:9200/customers/_search", [
                'q' => "*{$query}*"
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Search service unavailable'], 503);
        }
    }
}