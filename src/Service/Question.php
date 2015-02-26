<?php

namespace CloudExam\Exam\Service; 

use CloudExam\Exam\Repository\Question as QuestionRepository;
use CloudExam\Exam\Repository\Exam as ExamRepository;
use CloudExam\Exam\Service\Choice as ChoiceService; 

class Question
{
    protected $questionRepository; 
    protected $examRepository; 
    protected $choiceService; 

    public function __construct(ChoiceService $choiceService, QuestionRepository $repo, ExamRepository $examRepo)
    {
        $this->questionRepository = $repo; 
        $this->examRepository = $examRepo;
        $this->choiceService = $choiceService; 
    }

    /**
    * @method findByExam
    */ 
    public function getByExam($examSlug)
    {
        $exam = $this->examRepository->findOneBySlug($examSlug);

        $questions = $this->questionRepository->findByExam($exam->getId()); 
        if (is_null($questions)) {
            $questions = []; 
        }
        $transfers = [];
        foreach ($questions as $question) {
            $transfers[] = $this->get($question->getId());
        }

        return $transfers;
    }

    /**
    * @method findOneById
    */ 
    public function get($questionId) 
    {
        $question = $this->questionRepository->findOneById($questionId);

        if (is_null($question)) {
            return null;
        }
        $transfer = $this->questionRepository->asTransfer($question);
        
        $choices = $this->choiceService->getChoicesByQuestion($questionId);
        $transfer->setChoices($choices); 

        return $transfer;
    }
}
