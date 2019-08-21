<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf5b1721043d5dd9ffc8adfa4a1d7a2b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf5b1721043d5dd9ffc8adfa4a1d7a2b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf5b1721043d5dd9ffc8adfa4a1d7a2b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
