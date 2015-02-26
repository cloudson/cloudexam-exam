<?php

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/settings.php";

use CloudExam\Exam\Service\Exam;
use CloudExam\Exam\Service\Question;
use CloudExam\Exam\Service\Choice;

$app = new Silex\Application;
$app['debug'] = !ENV_PROD; 
require_once __DIR__."/../config/database.php";

$app->get("/", function(){
	phpinfo();
    return "Application is alive!";
});

$app->get('/exam', function() use ($app) {
	$examRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Exam');
	$service = new Exam($examRepo);
	$exams = $service->getAll([
		'OrderBy' => [ 'createdAt' => 'desc' ] 
	]);

	return json_encode($exams);
});

$app->get('/exam/{slug}', function($slug) use ($app) {
	$examRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Exam');
	$service = new Exam($examRepo);
	$exam = $service->get($slug);

	return json_encode($exam);
});

$app->get('/question/{questionId}', function($questionId) use($app) {
    $choiceRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Choice');
    $choiceService = new Choice($choiceRepo);
    $questionRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Question');

    $service = new Question($choiceService, $questionRepo); 
    
    return json_encode($service->get($questionId));
});

$app->after(function($request, $response){
	$response->headers->set('Content-Type', 'Application/json');
});

$app->run();
