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
        $transfers = [];
        foreach ($questions as $question) {
            $transfers[] = $this->asTransfer($question);
        }

        return $transfers;
    }

    public function get($questionId) 
    {
        $question = $this->repository->findOneById($questionId);
        if (is_null($question)) {
            return null;
        }

        return $this->asTransfer($question);
    }

    protected function asTransfer($question)
    {
        $transfer = new QuestionTransfer;
        $transfer->setId($question->getId());
        $transfer->setName($question->getName());
    
        return $transfer;     
    }

}
