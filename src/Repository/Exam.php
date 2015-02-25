<?php 

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository; 

class Exam extends EntityRepository
{
	use Hydrate;

    public function findLast(Array $criteria)
    {

    }
}
