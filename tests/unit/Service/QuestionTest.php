<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Entity\Question as QuestionEntity;
use CloudExam\Exam\Transfer\Question as QuestionTransfer;
use CloudExam\Exam\Entity\Exam as ExamEntity;
use CloudExam\Exam\Transfer\Choice as ChoiceTransfer;

class QuestionTest extends \PHPUnit_Framework_TestCase
{
    protected $service; 
    protected $repositoryMock; 
    protected $choiceServiceMock; 
    protected $examRepositoryMock;

    public function setUp()
    {
        $this->repositoryMock = $this->getMockBuilder('CloudExam\Exam\Repository\Question')->disableOriginalConstructor()->getMock();
        $this->examRepositoryMock = $this->getMockBuilder('CloudExam\Exam\Repository\Exam')->disableOriginalConstructor()->getMock();
        $this->choiceServiceMock = $this->getMockBuilder('CloudExam\Exam\Service\Choice')->disableOriginalConstructor()->getMock(); 
        $this->service = new Question($this->choiceServiceMock, $this->repositoryMock, $this->examRepositoryMock); 
    }

    /**
     * @test
     */ 
    public function shouldReturnsQuestionsByExam()
    {
        $examSlug = 'zce';
        $examId = 66;  
        $exam = new ExamEntity;
        $exam->setId($examId);
        $exam->setSlug($examSlug);

        
        $transfer1 = new QuestionTransfer; 
        $transfer1->setTitle('Question one');

        $transfer2 = new QuestionTransfer; 
        $transfer2->setTitle('Question two');
 
        $expected = [
            $transfer1,
            $transfer2
        ]; 
        $q1 = new QuestionEntity; 
        $q1->setId(1);
        $q1->setTitle('Question one');

        $q2 = new QuestionEntity; 
        $q2->setId(2);
        $q2->setTitle('Question two');

        $this->examRepositoryMock->method('__call')->with('findOneBySlug', [$examSlug])->will($this->returnValue($exam));

        $this->repositoryMock->method('asTransfer')
            ->will($this->returnCallback(function($entity) use ($q2, $transfer1, $transfer2) {
            if ($entity === $q2) {
                return $transfer2;;
            }  
            return $transfer1;
        }));
        $this->repositoryMock->expects($this->any())->method('__call')->will($this->returnCallback(function($name, $args) use ($q1, $q2){
            if ($name == 'findByExam') {
                return [
                   $q1,
                   $q2
                ];
            }

            if ($name == 'findOneById') {
                return ($args[0] == $q1->getId()) ? $q1 : $q2 ;
            } 

        })); 
        $this->choiceServiceMock->expects($this->exactly(2))->method('getChoicesByQuestion')->will($this->returnValue([])); 

        $questions = $this->service->getByExam($examSlug);

        $this->assertEquals($expected, $questions);
    }
    
    /**
     * @test
     */
    public function shouldReturnAnEmptyArrayWhenQuestionsIsNotFound()
    {
        $examSlug = 'lp1';
        $examId = 66;  
        $exam = new ExamEntity;
        $exam->setId($examId);
        $exam->setSlug($examSlug);

        $this->examRepositoryMock->method('__call')->with('findOneBySlug', [$examSlug])->will($this->returnValue($exam));
        $this->repositoryMock->expects($this->once())->method('__call')->with('findByExam', [$examId] )->will($this->returnValue(null)); 
        $questions = $this->service->getByExam($examSlug);

        $this->assertInternalType('array', $questions);
    }

    /**
     * @test
     */ 
    public function shouldReturnsAQuestion() 
    {
        $questionId = 66;  
        $transfer1 = new QuestionTransfer; 
        $transfer1->setTitle('Question one');

        $q1 = new QuestionEntity; 
        $q1->setId(1);
        $q1->setTitle('Question one');

        $this->repositoryMock->expects($this->once())->method('__call')->with('findOneById', [$questionId])->will($this->returnValue($q1)); 
        $this->repositoryMock->method('asTransfer')->will($this->returnValue($transfer1));
        $this->choiceServiceMock->expects($this->once())->method('getChoicesByQuestion')->with($questionId)->will($this->returnValue([])); 

        $question = $this->service->get($questionId); 

        $this->assertEquals($transfer1, $question);
    }

    /**
     * @test
     */
    public function shouldGetQuestionWithEmbededChoices()
    {
        $c1 = new ChoiceTransfer; 
        $c1->setTitle('Option 1');
        $c2 = new ChoiceTransfer; 
        $c2->setTitle('Option 2');
        $c3 = new ChoiceTransfer; 
        $c3->setTitle('Option 3');
        $c4 = new ChoiceTransfer; 
        $c4->setTitle('Option 4');

        $q1 = new QuestionEntity; 
        $q1->setTitle('Question one');
 
        $questionId = 66;  
        $transfer1 = new QuestionTransfer; 
        $transfer1->setTitle('Question one');
        $transfer1->setChoices([
            $c1, $c2, $c3, $c4 
        ]); 

        $this->repositoryMock->expects($this->once())->method('__call')->with('findOneById', [$questionId])->will($this->returnValue($q1)); 
        $this->repositoryMock->method('asTransfer')->will($this->returnValue($transfer1));
        $this->choiceServiceMock->expects($this->once())->method('getChoicesByQuestion')->with($questionId)->will($this->returnValue([
            $c1, $c2, $c3, $c4
        ]));
            
        $question = $this->service->get($questionId); 

        $this->assertEquals($transfer1->getChoices(), [$c1, $c2, $c3, $c4]);
    }

    /**
     * @test
     */ 
    public function shouldReturnsNullIfQuestionIsNotFound()
    {   
        $questionId = 66;
        
        $this->repositoryMock->expects($this->once())->method('__call')->with('findOneById', [$questionId])->will($this->returnValue(null)); 

        $this->assertNull($this->service->get($questionId));
    }
}
