<?php

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository;

class Question extends EntityRepository
{
    public function findByExam($questionId)
    {
        return $this->getEntityManager()->findAll([
            'exam_id' => $questionId
        ]);
    }   
}
