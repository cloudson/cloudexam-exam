<?php

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository;

class Choice extends EntityRepository
{
	use Hydrate;
}
