<?php 

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository; 

class Exam extends EntityRepository
{
    public function findBySlug($slug)
    {
        return $this->getEntityManager()->find([
            'slug' => $slug
        ]);
    }
}
