<?php

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository;

class Question extends EntityRepository
{
    public function findByQuestion($questionId)
    {
        return $this->getEntityManager()->findAll([
            'question_id' => $questionId
        ]);
    }   
}
