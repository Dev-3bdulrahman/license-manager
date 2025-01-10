<?php
namespace Dev3bdulrahman\LicenseManager\Http\Controllers;

use Illuminate\Routing\Controller;
use Dev3bdulrahman\LicenseManager\Models\License;
use Dev3bdulrahman\LicenseManager\Models\Customer;
use Dev3bdulrahman\LicenseManager\Services\LicenseManager;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LicenseController extends Controller
{
    public function __construct(private LicenseManager $licenseManager)
    {
    }

    public function index()
    {
        $licenses = License::with(['customer', 'domains'])->get();
        $customers = Customer::all();
        return view('license-manager::licenses.index', compact('licenses', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|in:single,multiple',
            'domains' => 'required|string',
            'end_date' => 'required|date|after:today',
        ]);

        $customer = Customer::find($validated['customer_id']);
        
        $this->licenseManager->createLicense([
            'customer_name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
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
}