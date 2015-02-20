<?php

namespace CloudExam\Exam\Entity;

class Attempt
{

	private $choice;


	public function setChoice($choice)
	{
		$this->choice = $choice;
	}

	public function getChoice()
	{
		return $this->choice;
	}
}