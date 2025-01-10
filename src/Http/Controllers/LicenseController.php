<?php

namespace Dev3bdulrahman\LicenseManager\Http\Controllers;

use Carbon\Carbon;
use Dev3bdulrahman\LicenseManager\Models\Customer;
use Dev3bdulrahman\LicenseManager\Models\License;
use Dev3bdulrahman\LicenseManager\Models\Product;
use Dev3bdulrahman\LicenseManager\Services\LicenseManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LicenseController extends Controller
{
    public function __construct(private LicenseManager $licenseManager)
    {
    }

    public function index()
    {
        $licenses = License::with(['customer', 'domains', 'product'])->get();
        $customers = Customer::all();
        $products = Product::all();

        return view('license-manager::licenses.index', compact('licenses', 'customers', 'products'));
    }

    public function show(License $license)
    {
        return view('license-manager::licenses.show', compact('license'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:single,multiple',
            'domains' => 'required|string',
            'end_date' => 'required|date|after:today',
        ]);
        $customer = Customer::find($validated['customer_id']);
        $product = Product::find($validated['product_id']);

        // dd($validated);
        $this->licenseManager->createLicense([
            'customer_name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'product_id' => $product->id,
            'type' => $validated['type'],
            'domains' => explode(',', str_replace(' ', '', $validated['domains'])),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::parse($validated['end_date']),
        ]);

        return redirect()->route('license-manager.licenses.index')
            ->with('success', 'License created successfully');
    }

    public function suspend(License $license)
    {
        $this->licenseManager->suspendLicense($license->license_key);

        return redirect()->route('license-manager.licenses.index')
            ->with('success', 'License suspended successfully');
    }

    public function reactivate(License $license)
    {
        $this->licenseManager->reactivateLicense($license->license_key);

        return redirect()->route('license-manager.licenses.index')
            ->with('success', 'License reactivated successfully');
    }
}
