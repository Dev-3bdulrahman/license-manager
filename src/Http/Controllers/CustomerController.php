<?php
namespace Dev3bdulrahman\LicenseManager\Http\Controllers;

use Illuminate\Routing\Controller;
use Dev3bdulrahman\LicenseManager\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('licenses')->get();
        return view('license-manager::customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|string|max:20',
        ]);

        Customer::create($validated);

        return redirect()->route('license-manager.customers.index')
            ->with('success', 'Customer created successfully');
    }

    public function show(Customer $customer)
    {
        return view('license-manager::customers.show', compact('customer'));
    }
}