<?php

namespace CloudExam\Exam\Repository;

use CloudExam\Exam\Entity\Question as QuestionEntity;

class QuestionTest extends \PHPUnit_Framework_TestCase
{

	private $em;
	private $repo;

	public function setUp()
	{
		$this->em = $this->getMockBuilder('\Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
		$classmeta = $this->getMockBuilder('\Doctrine\ORM\Mapping\ClassMetadata')->disableOriginalConstructor()->getMock();
		
		$this->repo = new Question($this->em, $classmeta);
	}

	/**
	* @test
	*/ 
	public function shouldTestEntityConvertToTransfer()
	{
		$entity = new QuestionEntity;

		$this->assertInstanceOf('\CloudExam\Exam\Transfer\Question', $this->repo->asTransfer($entity));
	}
}