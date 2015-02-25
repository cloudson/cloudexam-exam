<?php

namespace CloudExam\Exam\Repository;

use Doctrine\ORM\EntityRepository;
use CloudExam\Exam\Repository\Hydrate;

class Question extends EntityRepository
{
	use Hydrate;
}
