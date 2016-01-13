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

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'dbs.options' => array (
		'default' => array(
				'driver'    => 'pdo_mysql',
				'host'      => '172.17.0.2',
				'dbname'    => 'silex_ex',
				'user'      => 'root',
				'password'  => 'root',
				'charset'   => 'utf8',
		),
	),
));

// Глобальный мидлвер
$app->before(function () use ($app) {
	// Регистрируем главный лайауt для всех страниц
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

$app->get('/blog', function () use ($app) {
		$sql = "SELECT * FROM posts";
		$posts = $app['db']->fetchAssoc($sql, array((int) $id));

		if (!$posts) {
			return  "<i>No posts</i>";
		}

		var_dump($posts);

		return  "...";
});

$app->get('/blog/{id}', function ($id) use ($app) {
		$sql = "SELECT * FROM posts WHERE id = ?";
		$post = $app['db']->fetchAssoc($sql, array((int) $id));

		return  "<h1>{$post['title']}</h1>".
				"<p>{$post['content']}</p>";
});

$app->finish(function() {

	//Класс MyCompanyNamespace\SuperLogger определён в Composer-пакете mycompany/superlogger
	//Благодаря сгенерированному autoloader.php нужный файл с описанием класса подключится автоматически
	$logger = new MyCompanyNamespace\SuperLogger();
	$logger->writeLog('log.txt', 'Someone visited the page');

});

$app->run();
