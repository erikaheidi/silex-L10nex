<?php

$app = require __DIR__.'/bootstrap.php';

/*
 * load only the necessary language files, 
 * according to the current selected language in session (if any)
 *  */
$lang = "en";
if ($app['session']->get('current_language')) {
	$lang = $app['session']->get('current_language');
}

foreach (glob(__DIR__ . '/locale/'. $lang . '/*.yml') as $locale) {
	$app['translator']->addResource('yaml', $locale, $lang);
}

/* sets current language */
$app['translator']->setLocale($lang);

$app->get('/lang/{lang}', function($lang) use($app) {
	/*
	 * check if language exists
	 */
	if (is_dir(__DIR__ . '/locale/' . $lang)) {
		/* save user selection in session */		
		$app['session']->set('current_language', $lang);		
	}
	
	return $app->redirect($_SERVER['HTTP_REFERER']);
});

$app->get('/', function() use ($app) {
	/*
	 * search for available languages in locale dir
	 */
	foreach(glob(__DIR__ . '/locale/*') as $locale) {
		$languages[] = basename($locale);
	}
		    
    return $app['twig']->render('index.twig.html', array('languages' => $languages));
});


return $app;