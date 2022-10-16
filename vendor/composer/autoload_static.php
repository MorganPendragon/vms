<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc7f4af2b1a6f269ec82ef3035ff35298
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
        ),
        'L' => 
        array (
            'Laminas\\Escaper\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'Laminas\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-escaper/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc7f4af2b1a6f269ec82ef3035ff35298::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc7f4af2b1a6f269ec82ef3035ff35298::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc7f4af2b1a6f269ec82ef3035ff35298::$classMap;

        }, null, ClassLoader::class);
    }
}
