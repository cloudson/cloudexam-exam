<?php

namespace CloudExam\Exam\Service;

use CloudExam\Exam\Transfer\Attempt as AttemptTransfer;
use CloudExam\Exam\Repository\Attempt as AttemptRepository;
use CloudExam\Exam\Repository\Question as QuestionRepository;
use CloudExam\Exam\Repository\Choice as ChoiceRepository;
use CloudExam\Exam\Entity\Attempt as AttemptEntity;
use CloudExam\Exam\Entity\Question as QuestionEntity;
use CloudExam\Exam\Exception\EntityNotFoundException;

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
			throw new EntityNotFoundException(QuestionEntity::class, [
				'slug' => $transfer->getQuestionSlug()
			]);
		}

		$choice = $this->choiceRepo->findOneBy([
			'title' => $transfer->getChoiceTitle(),
			'questionId' => $question->getId()
		]);

		if (null === $choice) {
			throw new EntityNotFoundException(ChoiceEntity::class, [
				'title' => $transfer->getChoiceTitle(),
				'questionId' => $question->getId()	
			]);
		}
		
		$entity->setChoice($choice);

		return $entity;
	}
}
