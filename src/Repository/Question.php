<?php

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository;

class Question extends EntityRepository
{
	use Hydrate;
}
