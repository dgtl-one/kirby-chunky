<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitfab688248ab9135c8b064a4bb74d5390
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

        spl_autoload_register(array('ComposerAutoloaderInitfab688248ab9135c8b064a4bb74d5390', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitfab688248ab9135c8b064a4bb74d5390', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitfab688248ab9135c8b064a4bb74d5390::getInitializer($loader));

        $loader->setClassMapAuthoritative(true);
        $loader->setApcuPrefix('Dsf3sC3TYydjCYjIlE1GJ');
        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInitfab688248ab9135c8b064a4bb74d5390::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequirefab688248ab9135c8b064a4bb74d5390($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequirefab688248ab9135c8b064a4bb74d5390($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
