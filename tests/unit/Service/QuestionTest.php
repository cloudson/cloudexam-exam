<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Entity\Question as QuestionEntity;
use CloudExam\Exam\Transfer\Question as QuestionTransfer;
use CloudExam\Exam\Transfer\Choice as ChoiceTransfer;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    protected $service; 
    protected $repositoryMock; 
    protected $choiceServiceMock; 

    public function setUp()
    {
        $this->repositoryMock = $this->getMockBuilder('CloudExam\Exam\Repository\Question')->disableOriginalConstructor()->getMock();
        $this->choiceServiceMock = $this->getMockBuilder('CloudExam\Exam\Service\Choice')->disableOriginalConstructor()->getMock(); 
        $this->service = new Question($this->choiceServiceMock, $this->repositoryMock); 
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

        $this->repositoryMock->expects($this->once())->method('__call')->with('findByExam', [$examId])->will($this->returnValue([
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
        $this->repositoryMock->expects($this->once())->method('__call')->with('findByExam', [$examId] )->will($this->returnValue(null)); 
        $questions = $this->service->getByExam($examId);

        $this->assertInternalType('array', $questions);
    }

    /**
     * @test
     */ 
    public function shouldReturnsAQuestion() 
    {
        $questionId = 66;  
        $transfer1 = new QuestionTransfer; 
        $transfer1->setId(1); 
        $transfer1->setName('Question one');

        $q1 = new QuestionEntity; 
        $q1->setId(1);
        $q1->setName('Question one');

        $this->repositoryMock->expects($this->once())->method('__call')->with('findOneById', [$questionId])->will($this->returnValue($q1)); 
        $this->choiceServiceMock->expects($this->once())->method('getChoicesByQuestion')->with($questionId)->will($this->returnValue([])); 

        $question = $this->service->get($questionId); 

        $this->assertEquals($transfer1, $question);
    }

    /**
     * @test
     */
    public function shouldGetQuestionWithEmbededChoices()
    {
        $op1 = new ChoiceTransfer; 
        $op1->setName('Option 1');
        $op2 = new ChoiceTransfer; 
        $op2->setName('Option 2');
        $op3 = new ChoiceTransfer; 
        $op3->setName('Option 3');
        $op4 = new ChoiceTransfer; 
        $op4->setName('Option 4');

        $q1 = new QuestionEntity; 
        $q1->setId(1);
        $q1->setName('Question one');
 
        $questionId = 66;  
        $transfer1 = new QuestionTransfer; 
        $transfer1->setId(1); 
        $transfer1->setName('Question one');
        $transfer1->setChoices([
            $q1, $q2, $q3, $q4 
        ]); 

        $this->repositoryMock->expects($this->once())->method('__call')->with('findOneById', [$questionId])->will($this->returnValue($q1)); 
        $this->choiceServiceMock->expects($this->once())->method('getChoicesByQuestion')->with($questionId)->will($this->returnValue([
            $q1, $q2, $q3, $q4
        ]));
            
        $question = $this->service->get($questionId); 

        $this->assertEquals($transfer1->getChoices(), [$q1, $q2, $q3, $q4]);

    }
}
