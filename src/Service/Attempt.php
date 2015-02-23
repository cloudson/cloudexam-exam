<?php

namespace CloudExam\Exam\Service;

use CloudExam\Exam\Transfer\Attempt as AttemptTransfer;
use CloudExam\Exam\Repository\Attempt as AttemptRepository;
use CloudExam\Exam\Repository\Question as QuestionRepository;
use CloudExam\Exam\Repository\Choice as ChoiceRepository;
use CloudExam\Exam\Entity\Attempt as AttemptEntity;

class Attempt 
{

	private $repo;
	private $questionRepo;
	private $choiceRepo;

	public function __construct(AttemptRepository $repo, QuestionRepository $questionRepo, ChoiceRepository $choiceRepo)
	{
		$this->repo = $repo;
		$this->questionRepo = $questionRepo;
		$this->choiceRepo = $choiceRepo;
	}

	public function create(AttemptTransfer $transfer)
	{	
		$entity = $this->asEntity($transfer);
		
		return $this->repo->doTry($entity);
    }

    public function check(AttemptTransfer $transfer) 
    {
        $entity = $this->asEntity($transfer);
        if ($entity) {
            $choice = $entity->getChoice(); 
		    $question = $this->questionRepo->findOneBySlug($transfer->getQuestionSlug());

            $correct = $question->getChoice();

            return $correct->getTitle() == $choice->getTitle();  
        }

        return false;
    }

	private function asEntity(AttemptTransfer $transfer)
	{
		$entity = new AttemptEntity;
		$question = $this->questionRepo->findOneBySlug($transfer->getQuestionSlug());
		if (is_null($question)) {
			return $entity;
		}

		$choice = $this->choiceRepo->findOneBy([
			'title' => $transfer->getChoiceTitle(),
			'questionId' => $question->getId()
		]);
		
		$entity->setChoice($choice);

		return $entity;
	}
}
