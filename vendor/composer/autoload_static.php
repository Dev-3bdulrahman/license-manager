<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitff875a2c448d58e21b0230c4f9690e96
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dev3bdulrahman\\LicenseManager\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dev3bdulrahman\\LicenseManager\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitff875a2c448d58e21b0230c4f9690e96::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitff875a2c448d58e21b0230c4f9690e96::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitff875a2c448d58e21b0230c4f9690e96::$classMap;

        }, null, ClassLoader::class);
    }
}
