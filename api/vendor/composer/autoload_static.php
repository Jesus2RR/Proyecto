<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit732dd322185c8a28396f4015e5c8ea06
{
    public static $prefixesPsr0 = array (
        'E' => 
        array (
            'Esendex' => 
            array (
                0 => __DIR__ . '/..' . '/esendex/sdk/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit732dd322185c8a28396f4015e5c8ea06::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit732dd322185c8a28396f4015e5c8ea06::$classMap;

        }, null, ClassLoader::class);
    }
}
