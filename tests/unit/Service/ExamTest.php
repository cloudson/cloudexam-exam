<?php

namespace CloudExam\Exam\Service;


use CloudExam\Exam\Transfer\Exam as ExamTransfer; 
use CloudExam\Exam\Entity\Exam as ExamEntity; 

class ExamTest extends \PHPUnit_Framework_TestCase
{

    protected $examService; 
    protected $repo; 

    public function setUp() 
    {
        $this->repo = $this->getMockBuilder('\CloudExam\Exam\Repository\Exam')->disableOriginalConstructor()->getMock(); 
        $this->service = new Exam($this->repo); 
    }

     /**
      * @test
      */
    public function shouldReturnsAnExamAsTransfer() 
    {
        $name = "ZCE 2011"; 
        $expected = new ExamTransfer; 
        $expected->setName($name);

        $stub = new ExamEntity; 
        $stub->setName($name);

        $slug = 'zce2011';
        $this->repo->expects($this->once())->method('__call')->with('findBySlug', [$slug])->will($this->returnValue($stub)); 
        $this->repo->method('asTransfer')->will($this->returnValue($expected));
        $exam = $this->service->get($slug);  

        $this->assertEquals($expected, $exam);
    }

    /**
     * @test 
     */ 
    public function shouldReturnsNullIfExamIsNotFound()
    {
        $slug = 'Wally';
        $this->repo->expects($this->once())->method('__call')->with('findBySlug', [$slug])->will($this->returnValue(null)); 

        $exam = $this->service->get($slug);

        $this->assertNull($exam);
    }

    /**
    * @test
    */ 
    public function shouldReturnsLastExams()
    {
        $exam1 = new ExamTransfer;
        $exam1->setName('ZCE');

        $exam2 = new ExamTransfer;
        $exam2->setName('LC1');        

        $e1 = new ExamEntity;
        $e1->setName($exam1->getName());

        $e2 = new ExamEntity;
        $e2->setName($exam2->getName());

        $expected = [
            $exam2, $exam1
        ];

        $this->repo->expects($this->once())->method('findLast')->will($this->returnValue([
                $e2, $e1
        ]));
        $this->repo->method('asTransfer')
            ->will($this->returnCallback(function($entity) use ($e1, $exam1, $exam2){
                if ($e1 === $entity) {
                    return $exam1; 
                }
                return $exam2;
            }));

        $collection = $this->service->getAll([
            'limit' => 2
        ]);

        $this->assertEquals($expected, $collection);
    }
}
