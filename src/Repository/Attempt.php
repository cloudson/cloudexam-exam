<?php

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository;
use CloudExam\Exam\Entity\Attempt as AttemptEntity;

class Attempt extends EntityRepository
{
	use Hydrate; 
	
	public function doTry(AttemptEntity $entity)
	{
		
	}
}