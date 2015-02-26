<?php 

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository; 
use Doctrine\Common\Collections\Criteria;

class Exam extends EntityRepository
{
	use Hydrate;

    public function findLast(Array $criteria)
    {
    	$defaultCriteria = [
    		'OrderBy' => ['id' => 'DESC']	
    	];

    	$criteria = array_merge($defaultCriteria, $criteria);
    	$OrderBy = $criteria['OrderBy'];
    	unset($criteria['OrderBy']);

    	return $this->findBy($criteria, $OrderBy);	
    }

    public function asTransfer($entity)
    {
        $transfer = Hydrate::asTransfer($entity);
        $transfer->setQuestionsURI("/exam/".$transfer->getSlug()."/questions");

        return $transfer;
    }
}
