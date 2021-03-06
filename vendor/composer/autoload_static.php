<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit998fcdb9b8c9d265c92f5a444d9971ef
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
        'G' => 
        array (
            'GatewayWorker\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
        'GatewayWorker\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/gateway-worker/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit998fcdb9b8c9d265c92f5a444d9971ef::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit998fcdb9b8c9d265c92f5a444d9971ef::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
