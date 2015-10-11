<?php
require_once __DIR__ . '/../vendor/autoload.php';

//Используем микрофреймворк Silex
$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

//И шаблонизатор Twig, который легко интегрируется в Silex
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/../views'
));

// Глобальный мидлвер
$app->before(function () use ($app) {
	// Регистрируем главный лайаун для всех страниц
	$app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
});

//При заходе в корень нашего сайта, сработает контроллер описанный в анонимной функции ниже
$app->get('/', function() use ($app) {

	$templateVars = array(
		'title' => 'Home page',
		'head' => 'Welcome to our site'
	);

	//Рендрим шаблон и выводим его в браузер пользователя
	return $app['twig']->render('index.twig', $templateVars);

})->bind('index');

$app->get('/about', function() use ($app) {

	$templateVars = array(
		'title' => 'About us',
		'head' => 'Who are we?'
	);

	//Рендрим шаблон и выводим его в браузер пользователя
	return $app['twig']->render('about.twig', $templateVars);

})->bind('about');

$app->get('/contact', function() use ($app) {

	$templateVars = array(
		'title' => 'Contact page',
		'head' => 'Where are we from?'
	);

	//Рендрим шаблон и выводим его в браузер пользователя
	return $app['twig']->render('contact.twig', $templateVars);

})->bind('contact');

$app->finish(function() {

	//Класс MyCompanyNamespace\SuperLogger определён в Composer-пакете mycompany/superlogger
	//Благодаря сгенерированному autoloader.php нужный файл с описанием класса подключится автоматически
	$logger = new MyCompanyNamespace\SuperLogger();
	$logger->writeLog('log.txt', 'Someone visited the page');

});

$app->run();
