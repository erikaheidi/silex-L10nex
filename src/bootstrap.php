<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/templates'
));
$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
		'locale_fallback' => 'en',
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
	$translator->addLoader('yaml', new YamlFileLoader());

	return $translator;
}));

return $app;