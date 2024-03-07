<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit617501ac91ccf0e7e599a5974d0459cb
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SaboCore\\Routing\\' => 17,
            'SaboCore\\Config\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SaboCore\\Routing\\' => 
        array (
            0 => __DIR__ . '/../..' . '/routing',
        ),
        'SaboCore\\Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SaboCore\\Config\\Config' => __DIR__ . '/../..' . '/config/Config.php',
        'SaboCore\\Config\\ConfigException' => __DIR__ . '/../..' . '/config/ConfigException.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit617501ac91ccf0e7e599a5974d0459cb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit617501ac91ccf0e7e599a5974d0459cb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit617501ac91ccf0e7e599a5974d0459cb::$classMap;

        }, null, ClassLoader::class);
    }
}
