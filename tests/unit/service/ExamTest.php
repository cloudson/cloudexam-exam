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
        $this->repo->expects($this->once())->method('findBySlug')->with($slug)->will($this->returnValue($stub)); 
        $exam = $this->service->get($slug);  

        $this->assertEquals($expected, $exam);
    }

    /**
     * @test 
     */ 
    public function shouldReturnsNullIfExamIsNotFound()
    {
        $slug = 'Wally';
        $this->repo->expects($this->once())->method('findBySlug')->with($slug)->will($this->returnValue(null)); 
        $exam = $this->service->get($slug);

        $this->assertNull($exam);
    }
}
