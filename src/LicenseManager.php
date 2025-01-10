<?php

namespace Dev3bdulrahman\LicenseManager;

class LicenseManager
{
    public static function validateLicense($licenseKey, $domain)
    {
        // افحص الترخيص عبر قاعدة البيانات
        $licenses = [
            'ABC123' => 'example.com',
            'XYZ789' => 'anotherdomain.com',
        ];

        if (isset($licenses[$licenseKey]) && $licenses[$licenseKey] === $domain) {
            return true;
        }

        return false;
    }

    public static function generateLicense()
    {
        return strtoupper(bin2hex(random_bytes(8)));
    }
}

