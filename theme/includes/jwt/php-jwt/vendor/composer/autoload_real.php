<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit5c8c1a9356a51dcf7d1efc204e276b6d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit5c8c1a9356a51dcf7d1efc204e276b6d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit5c8c1a9356a51dcf7d1efc204e276b6d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit5c8c1a9356a51dcf7d1efc204e276b6d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
