<?php 

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository; 

class Exam extends EntityRepository
{
    // public function findBySlug($slug)
    // {
    //     return $this->getEntityManager()->findBy([
    //         'slug' => $slug
    //     ]);
    // }

    public function findLast(Array $criteria)
    {

    }
}
