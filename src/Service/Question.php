<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Repository\Question as QuestionRepository;
use CloudExam\Exam\Service\Choice as ChoiceService; 

class Question
{
    protected $repository; 
    protected $choiceService; 

    public function __construct(ChoiceService $choiceService, QuestionRepository $repo)
    {
        $this->repository = $repo; 
        $this->choiceService = $choiceService; 
    }

    /**
    * @method findByExam
    */ 
    public function getByExam($examId)
    {
        $questions = $this->repository->findByExam($examId); 
        if (is_null($questions)) {
            $questions = []; 
        }
        $transfers = [];
        foreach ($questions as $question) {
            $transfers[] = $this->repository->asTransfer($question);
        }

        return $transfers;
    }

    /**
    * @method findOneById
    */ 
    public function get($questionId) 
    {
        $question = $this->repository->findOneById($questionId);

        if (is_null($question)) {
            return null;
        }
        $transfer = $this->repository->asTransfer($question);
        
        $choices = $this->choiceService->getChoicesByQuestion($questionId);
        $transfer->setChoices($choices); 

        return $transfer;
    }
}
