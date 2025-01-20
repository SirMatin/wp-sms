<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64757a0efca15ae57d8dca038a4b6344
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WP_SMS\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WP_SMS\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit64757a0efca15ae57d8dca038a4b6344::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64757a0efca15ae57d8dca038a4b6344::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit64757a0efca15ae57d8dca038a4b6344::$classMap;

        }, null, ClassLoader::class);
    }
}
