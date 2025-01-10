<?php
namespace Dev3bdulrahman\LicenseManager\Http\Controllers;

use Illuminate\Routing\Controller;
use Dev3bdulrahman\LicenseManager\Models\Customer;
use Dev3bdulrahman\LicenseManager\Models\License;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Customer::count();
        $activeLicenses = License::where('status', 'active')->count();
        $expiringSoon = License::where('status', 'active')
            ->where('end_date', '<=', Carbon::now()->addDays(30))
            ->count();
        
        $recentLicenses = License::with('customer')
            ->latest()
            ->take(10)
            ->get();

        return view('license-manager::dashboard', compact(
            'totalCustomers',
            'activeLicenses',
            'expiringSoon',
            'recentLicenses'
        ));
    }
}