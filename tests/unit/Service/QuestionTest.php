<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Entity\Question as QuestionEntity;
use CloudExam\Exam\Transfer\Question as QuestionTransfer;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    protected $service; 
    protected $repositoryMock; 
    protected $choiceServiceMock; 

    public function setUp()
    {
        $this->repositoryMock = $this->getMockBuilder('CloudExam\Exam\Repository\Question')->disableOriginalConstructor()->getMock();
        $this->choiceServiceMock = $this->getMockBuilder('CloudExam\Exam\Service\Choice')->disableOriginalConstructor()->getMock(); 
        $this->service = new Question($this->repositoryMock); 
    }

    /**
     * @test
     */ 
    public function shouldReturnsQuestionsByExam()
    {
        $examId = 66;  
        $transfer1 = new QuestionTransfer; 
        $transfer1->setId(1); 
        $transfer1->setName('Question one');

        $transfer2 = new QuestionTransfer; 
        $transfer2->setId(2); 
        $transfer2->setName('Question two');
 
        $expected = [
            $transfer1,
            $transfer2
        ]; 
        $q1 = new QuestionEntity; 
        $q1->setId(1);
        $q1->setName('Question one');

        $q2 = new QuestionEntity; 
        $q2->setId(2);
        $q2->setName('Question two');

        $this->repositoryMock->expects($this->once())->method('findByExam')->with($examId)->will($this->returnValue([
           $q1,
           $q2
       ])); 

        $questions = $this->service->getByExam($examId);

        $this->assertEquals($expected, $questions);
    }
    
    /**
     * @test
     */
    public function shouldReturnAnEmptyArrayWhenQuestionsIsNotFound()
    {
        $examId = 666;
        $this->repositoryMock->expects($this->once())->method('findByExam')->with($examId)->will($this->returnValue(null)); 
        $questions = $this->service->getByExam($examId);

        $this->assertInternalType('array', $questions);
    }

    /*
     * @test
     */ 
    public function shouldReturnsAQuestion() 
    {
        $examId = 66;  
        $transfer1 = new QuestionTransfer; 
        $transfer1->setId(1); 
        $transfer1->setName('Question one');

        $q1 = new QuestionEntity; 
        $q1->setId(1);
        $q1->setName('Question one');

        $this->repositoryMock->expects($this->once())->method('findOneById')->with($examId)->will($this->returnValue($q1)); 

        $question = $this->service->get($examId); 

        $this->assertEquals($transfer, $question);
    }
}
