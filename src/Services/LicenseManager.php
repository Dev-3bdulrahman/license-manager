<?php

namespace Dev3bdulrahman\LicenseManager\Services;

use Carbon\Carbon;
use Dev3bdulrahman\LicenseManager\Models\Customer;
use Dev3bdulrahman\LicenseManager\Models\License;
use Dev3bdulrahman\LicenseManager\Models\LicenseDomain;
use Illuminate\Support\Str;

class LicenseManager
{
    public function validateLicense(string $licenseKey, string $domain): array
    {
        try {
            $license = License::with(['customer', 'domains'])
                ->where('license_key', $licenseKey)
                ->first();

            if (!$license) {
                return [
                    'valid' => false,
                    'message' => 'Invalid license key',
                ];
            }

            if ($license->status !== 'active') {
                return [
                    'valid' => false,
                    'message' => 'License is '.$license->status,
                ];
            }

            if (Carbon::now()->isAfter($license->end_date)) {
                $license->status = 'expired';
                $license->save();

                return [
                    'valid' => false,
                    'message' => 'License has expired',
                ];
            }

            $isValidDomain = $license->domains()
                ->where('domain', $domain)
                ->exists();

            if (!$isValidDomain) {
                return [
                    'valid' => false,
                    'message' => 'Domain not authorized for this license',
                ];
            }

            return [
                'valid' => true,
                'message' => 'License is valid',
                'license' => $license->toArray(),
            ];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'Error validating license: '.$e->getMessage(),
            ];
        }
    }

    public function generateLicense(): string
    {
        return strtoupper(implode('-', [
            Str::random(4),
            Str::random(4),
            Str::random(4),
            Str::random(4),
        ]));
    }

    public function createLicense(array $data): array
    {
        try {
            $customer = Customer::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['customer_name'],
                    'phone' => $data['phone'],
                ]
            );

            $license = License::create([
                'license_key' => $this->generateLicense(),
                'customer_id' => $customer->id,
                'type' => $data['type'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => 'active',
            ]);

            $domains = is_array($data['domains']) ? $data['domains'] : [$data['domains']];
            foreach ($domains as $domain) {
                LicenseDomain::create([
                    'license_id' => $license->id,
                    'domain' => $domain,
                ]);
            }

            return [
                'success' => true,
                'message' => 'License created successfully',
                'license' => $license->load(['customer', 'domains'])->toArray(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error creating license: '.$e->getMessage(),
            ];
        }
    }

    public function suspendLicense(string $licenseKey): array
    {
        try {
            $license = License::where('license_key', $licenseKey)->first();

            if (!$license) {
                return [
                    'success' => false,
                    'message' => 'License not found',
                ];
            }

            $license->status = 'suspended';
            $license->save();

            return [
                'success' => true,
                'message' => 'License suspended successfully',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error suspending license: '.$e->getMessage(),
            ];
        }
    }
}
