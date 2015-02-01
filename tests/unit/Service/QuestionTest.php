<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Entity\Question as QuestionEntity;
use CloudExam\Exam\Transfer\Question as QuestionTransfer;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    protected $service; 
    protected $repository; 

    public function setUp()
    {
        $this->repository = $this->getMockBuilder('CloudExam\Exam\Repository\Question')->disableOriginalConstructor()->getMock();
        $this->service = new Question($this->repository); 
    }

    /**
     * @test
     */ 
    public function shouldReturnsQuestionsByExam()
    {
        $questionId = 66;  
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

        $this->repository->expects($this->once())->method('findByQuestion')->with($questionId)->will($this->returnValue([
           $q1,
           $q2
       ])); 

        $questions = $this->service->getByQuestion($questionId);

        $this->assertEquals($expected, $questions);
    }
    
    /**
     * @test
     */
    public function shouldReturnAnEmptyArrayWhenQuestionsIsNotFound()
    {
        $questionId = 666;
        $this->repository->expects($this->once())->method('findByQuestion')->with($questionId)->will($this->returnValue(null)); 
        $questions = $this->service->getByQuestion($questionId);

        $this->assertInternalType('array', $questions);
    }
}
