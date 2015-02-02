<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Repository\Question as QuestionRepository;
use CloudExam\Exam\Transfer\Question as QuestionTransfer;

class Question
{
    protected $repository; 


    public function __construct(QuestionRepository $repo)
    {
        $this->repository = $repo; 
    }

    public function getByExam($examId)
    {
        $questions = $this->repository->findByExam($examId); 
        if (is_null($questions)) {
            $questions = []; 
        }
        return $this->asTransfer($questions);
    }

 //   public function get($)

    protected function asTransfer($questions)
    {
        $transfers = [];
        foreach ($questions as $question) {
            $transfer = new QuestionTransfer;
            $transfer->setId($question->getId());
            $transfer->setName($question->getName());

            $transfers[] = $transfer;
        }

        return $transfers;
    }

}
