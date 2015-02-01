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

    public function getByQuestion($questionId)
    {
        $questions = $this->repository->findByQuestion($questionId); 
        if (is_null($questions)) {
            return null;
        }
        return $this->asTransfer($questions);
    }
    
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
