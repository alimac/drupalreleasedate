<?php
require_once APPROOT . 'vendor/autoload.php';

$app = new Silex\Application();

$config = array();
if (file_exists(APPROOT . 'config/config.php')) {
    require_once(APPROOT . 'config/config.php');
}
$app['config'] = $config;

$app->register(
    new Silex\Provider\DoctrineServiceProvider(),
    array(
        'db.options' => $config['db'],
    )
);

if (isset($config['http_cache']) && $config['http_cache'] !== false) {
    $app->register(
        new Silex\Provider\HttpCacheServiceProvider(),
        array(
            'http_cache.cache_dir' => APPROOT . 'cache/http',
            'http_cache.esi'       => null,
            'http_cache.options'   => (isset($config['http_cache']) && is_array($config['http_cache']))? $config['http_cache'] : array(),
        )
    );
}

$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path'    => APPROOT . '/templates',
        'twig.options' => isset($config['twig']) ? $config['twig'] : array(),
    )
);

// Set config as a global variable for templates.
$app['twig'] = $app->share(
    $app->extend('twig',
        function ($twig, $app) use ($config) {
            $twig->addGlobal('config', $config);
            return $twig;
        }
    )
);
