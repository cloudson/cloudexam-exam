<?php

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../config/settings.php";

use CloudExam\Exam\Service\Exam;
use CloudExam\Exam\Service\Question;
use CloudExam\Exam\Service\Choice;
use CloudExam\Exam\Service\Attempt;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

$app->get("/exam/{slug}/questions", function($slug) use ($app){
	$choiceRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Choice');
    $choiceService = new Choice($choiceRepo);
    $questionRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Question');
    $examRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Exam');

    $service = new Question($choiceService, $questionRepo, $examRepo); 
    $questions = $service->getByExam($slug);

    return json_encode($questions);
});

$app->get('/question/{questionId}', function($questionId) use($app) {
    $choiceRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Choice');
    $choiceService = new Choice($choiceRepo);
    $questionRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Question');
    $examRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Exam');

    $service = new Question($choiceService, $questionRepo, $examRepo); 
    
    return json_encode($service->get($questionId));
});

$app->post('/success', function(Request $request) use ($app){
	$transfer = new CloudExam\Exam\Transfer\Attempt;
	$fields = array_keys((array) $transfer);
	
	foreach ($fields as $field) {
		$setter = "set" . ucfirst($field);
		$transfer->$setter($request->get($field));
	}

	$attemptRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Attempt');
	$questionRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Question');
	$choiceRepo = $app['db.em']->getRepository('\CloudExam\Exam\Entity\Choice');
	$service = new  Attempt($attemptRepo, $questionRepo, $choiceRepo);

	$status = Response::HTTP_OK;
	if (!$service->check($transfer)) {
		$status = Response::HTTP_NOT_FOUND;
	}

	return new Response('', $status);
});

$app->after(function($request, $response) {
	// $response->headers->set('Content-Type', 'Application/json');
});

$app->run();
