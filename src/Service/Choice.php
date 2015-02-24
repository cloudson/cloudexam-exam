<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Repository\Choice as ChoiceRepository;
use CloudExam\Exam\Transfer\Choice as ChoiceTransfer;

class Choice
{
    protected $repository; 

    public function __construct(ChoiceRepository $repo)
    {
        $this->repository = $repo; 
    }

    /**
    * @method findByQuestionId
    */ 
    public function getChoicesByQuestion($questionId) 
    {
        $choices = $this->repository->findByQuestionId($questionId);      
        $transfers = []; 
        foreach ($choices as $choice) {
            $transfers[] = $this->asTransfer($choice);
        }   

        return $transfers;
    }
    
    public function asTransfer($choice)
    {
        $transfer = new ChoiceTransfer;
        $transfer->setTitle($choice->getTitle());
 
        return $transfer;
    }

}

