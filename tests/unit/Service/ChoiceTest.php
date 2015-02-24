<?php

namespace CloudExam\Exam\Service;

use CloudExam\Exam\Entity\Choice as ChoiceEntity; 
use CloudExam\Exam\Transfer\Choice as ChoiceTransfer;

class ChoiceTest extends \PHPUnit_Framework_TestCase
{
    private $service; 

    public function setUp()
    {
        $this->repo = $this->getMockBuilder('\CloudExam\Exam\Repository\Choice')->disableOriginalConstructor()->getMock();
        $this->service = new Choice($this->repo); 
    }


    /**
     * @test
     */
    public function shouldReturnsEmptyChoicesIfQuestionIsIncomplete()
    {
        $this->repo->method('__call')->with('findByQuestionId')->will($this->returnValue([])); 

        $found = $this->service->getChoicesByQuestion(3);

        $this->assertEmpty($found);
    }

    /**
     * @test
     */
    public function shouldReturnSameEntitiesLikeTransfers()
    {
        $e1 = new ChoiceEntity; 
        $e1->setTitle('Java');

        $e2 = new ChoiceEntity;
        $e2->setTitle('Ruby');

        $t1 = new ChoiceTransfer; 
        $t1->setTitle('Java');

        $t2 = new ChoiceTransfer;
        $t2->setTitle('Ruby');

        $this->repo->method('__call')->with('findByQuestionId')->will($this->returnValue([
            $e1, $e2
        ])); 

        $found = $this->service->getChoicesByQuestion(3);

        $this->assertEquals([$t1, $t2], $found);

    }
}
