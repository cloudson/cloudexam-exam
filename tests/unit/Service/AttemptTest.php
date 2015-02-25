<?php

namespace CloudExam\Exam\Service;

use CloudExam\Exam\Transfer\Attempt as AttemptTransfer;
use CloudExam\Exam\Transfer\Choice as ChoiceTransfer;
use CloudExam\Exam\Transfer\Choice;
use CloudExam\Exam\Entity\Question as QuestionEntity;
use CloudExam\Exam\Entity\Choice as ChoiceEntity;

class AttemptTest extends \PHPUnit_Framework_TestCase
{
	private $service;

	private $attemptRepo;
	private $questionRepo;
	private $choiceRepo;

	public function setUp()
	{
		$this->attemptRepo = $this->getMockBuilder('\CloudExam\Exam\Repository\Attempt')
			->disableOriginalConstructor()
			->getMock();

		$this->questionRepo = $this->getMockBuilder('\CloudExam\Exam\Repository\Question')
			->disableOriginalConstructor()
			->getMock();

		$this->choiceRepo = $this->getMockBuilder('\CloudExam\Exam\Repository\Choice')
			->disableOriginalConstructor()
			->getMock();


		$this->service = new Attempt($this->attemptRepo, $this->questionRepo, $this->choiceRepo);
	}

	/**
	* @test
	*/ 
	public function shouldCreateAttempt()
	{

		$transfer = new AttemptTransfer;
		$transfer->setChoiceTitle('PHP');

		$this->attemptRepo->expects($this->once())->method('doTry');
		$this->service->create($transfer);
	}

	/**
	* @test
	*/ 
	public function shoulLoadQuestion()
	{
		
		$transfer = new AttemptTransfer;
		$transfer->setQuestionSlug('which-your-favorite-language');
		$transfer->setChoiceTitle('PHP');

		$question = new QuestionEntity;
		$question->setSlug('which-your-favorite-language');

		$this->questionRepo->expects($this->once())->method('__call')->with(
			'findOneBySlug',
			[$transfer->getQuestionSlug()]
		)->will($this->returnValue($question));

		$this->service->create($transfer);
	}

	/**
	* @test
	*/ 
	public function shouldLoadChoice()
	{
		$transfer = new AttemptTransfer;
		$transfer->setQuestionSlug('which-your-favorite-language');
		$transfer->setChoiceTitle('PHP');

		$question = new QuestionEntity;
		$question->setSlug('which-your-favorite-language');

		$this->questionRepo->method('__call')->with(
			'findOneBySlug',
			[$transfer->getQuestionSlug()]
		)->will($this->returnValue($question));

		$this->choiceRepo->expects($this->once())->method('findOneBy')->with([
				'questionId' => $question->getId(), 
				'title' => $transfer->getChoiceTitle()
			]
		);

		$this->service->create($transfer);
	}

    /**
     * @test
     */
    public function shouldCheckStatusOfAttempt()
    {
		$transfer = new AttemptTransfer;
		$transfer->setQuestionSlug('which-your-favorite-language');
		$transfer->setChoiceTitle('PHP');

        $correctChoice = new ChoiceEntity; 
        $correctChoice->setTitle('PHP'); 

        $question = new QuestionEntity;
        $question->setSlug('which-your-favorite-language');
        $question->setChoice($correctChoice);

		$this->questionRepo->method('__call')->with(
			'findOneBySlug',
			[$transfer->getQuestionSlug()]
		)->will($this->returnValue($question));

		$this->choiceRepo->method('findOneBy')->with([
				'questionId' => $question->getId(), 
				'title' => $transfer->getChoiceTitle()
			]
		)->will($this->returnValue($correctChoice));

        $this->assertTrue($this->service->check($transfer)); 
    }

    /**
    * @test
    */ 
    public function shouldSaysThatAttemptIsWrong()
    {
    	$transfer = new AttemptTransfer;
		$transfer->setQuestionSlug('which-your-favorite-language');
		$transfer->setChoiceTitle('PHP');

        $correctChoice = new ChoiceEntity; 
        $correctChoice->setTitle('Go'); 

        $question = new QuestionEntity;
        $question->setSlug('which-your-favorite-language');
        $question->setChoice($correctChoice);

		$this->questionRepo->method('__call')->with(
			'findOneBySlug',
			[$transfer->getQuestionSlug()]
		)->will($this->returnValue($question));

		$this->choiceRepo->method('findOneBy')->with([
				'questionId' => $question->getId(), 
				'title' => $transfer->getChoiceTitle()
			]
		)->will($this->returnValue($correctChoice));

        $this->assertTrue($this->service->check($transfer)); 
    }
}
